<!--Riprende la sessione PHP iniziata o ne crea una nuova.-->
<?php
    session_start();
    include "connessione_db.php";
?>
<!---->
<!--PAGINA DI TRANSIZIONE-->
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olympia | Acquisto - Annulla</title>
    <link type="text/css" rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="../vendor/fontawesome/css/all.min.css">
    <link type="text/css" rel="stylesheet" href="../css/navbar.css">
    <link type="text/css" rel="stylesheet" href="../css/pagina_transizione.css">
    <link type="text/css" rel="stylesheet" href="../css/swal.css">
    <script type="text/javascript" src="../vendor/jquery/jquery-3.4.1.slim.min.js"></script>
    <script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../vendor/fontawesome/js/all.min.js"></script>
    <script type="text/javascript" src="../vendor/sweetalert2/sweetalert2.min.js"></script>
    <script type="text/javascript" src="../js/navbar.js"></script>
</head>
<body onload="creaNavbar(); impostaVoci(); azionaVocePrincipale('SHOP');">
    <!--Navbar-->
    <header></header>
    <!--Navbar-->
    <main>
        <h1 class="text-center">ACQUISTO - ANNULLA</h1>
<!--Controlla, in ordine, che ci sia un utente loggato, che l'utente loggato sia un socio e che
la pagina sia stata chiamata con il metodo GET o con il metodo POST. Se almeno una delle tre
condizioni non viene soddisfatta, visualizza un alert con il corrispondente messaggio di errore.
Se non ci sono errori, procede o con l'acquisto o con l'annullamento di un acquisto di un prodotto
effettuando sul database le operazioni opportune. Se tutto è andato a buon fine, visualizza
un alert che avverte del successo dell'operazione e che, appena chiuso, reindirizza alla pagina
del carrello.-->
<?php
    if (! isset($_SESSION["loggato"]) || ! $_SESSION["loggato"])
    {
        echo("
        <p style='padding-bottom: 100%'></p>
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_errore', content: 'testo_errore',
        }, icon: 'error', title: 'NON SEI REGISTRATO...', html: 'Effettua il login o iscriviti.'
    }).then(function() {
        window.location.replace('../html/login.html');
    });
</script>");
        exit(1);
    }
    if ($_SESSION["ruolo"] != "socio")
    {
        echo("
        <p style='padding-bottom: 100%'></p>
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_errore', content: 'testo_errore',
        }, icon: 'error', title: 'SEI UN AMMINISTRATORE...', html: `Non puoi acquistare prodotti e/o
        annullarne l'acquisto.`
    }).then(function() {
        window.location.replace('../html/index.html');
    });
</script>");
        exit(1);
    }
    if ((! isset($_POST["nome_prodotto"]) && ! isset($_GET["azione"])))
    {
        echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_errore', content: 'testo_errore',
        }, icon: 'error', title: 'ERRORE...', html: 'Accesso negato!'
    }).then(function() {
        window.location.replace('../html/index.html');
    });
</script>");
        exit(1);
    }

    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../php/prodotti.php");

    $sql;
    $ris;

    switch ($_GET["azione"])
    {
    case "acquista":
        $versione = isset($_POST["versione"]) ? $_POST["versione"] : "";
        $nome_prodotto = "";

        if (isset($_POST["versione"]))
            $nome_prodotto = $_POST["nome_prodotto"] . " " . $versione;
        else
            $nome_prodotto = $_POST["nome_prodotto"];
            
        $qta_richiesta = intval($_POST["quantita" . $versione]);
        $sql = "SELECT qta_disponibile FROM prodotto WHERE nome = $1 AND qta_disponibile >= $2";
        $ris = @pg_query_params($conn, $sql, array($nome_prodotto, $qta_richiesta));
        controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
            Ci scusiamo per l'inconveniente...", false, "../php/prodotti.php");
        
        $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

        controllaRecord($conn, $sql, $record, "La disponibilità è minore della richiesta!",
            "../php/prodotti.php");

        $qta_disponibile = intval($record["qta_disponibile"]);
        @pg_free_result($ris);
        $ris = @pg_query($conn, "BEGIN");
        @pg_free_result($ris);
        $sql = "INSERT INTO acquisto VALUES ($1, $2, now(), $3,
            (SELECT $4 * prezzo FROM prodotto WHERE nome = $5))";
        $ris = @pg_query_params($conn, $sql, array($_SESSION["username"], $nome_prodotto,
            $qta_richiesta, $qta_richiesta, $nome_prodotto));
        controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
            Ci scusiamo per l'inconveniente...", true, "../php/prodotti.php");
        @pg_free_result($ris);
        $sql = "UPDATE prodotto SET qta_disponibile = $1 WHERE nome = $2";
        $ris = @pg_query_params($conn, $sql, array($qta_disponibile - $qta_richiesta,
            $nome_prodotto));
        controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
            Ci scusiamo per l'inconveniente...", true, "../php/prodotti.php");
        @pg_free_result($ris);
        $ris = @pg_query($conn, "COMMIT");
        @pg_free_result($ris);
        @pg_close($conn);
        echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_successo', content: 'testo_successo',
        }, icon: 'success', title: 'OPERAZIONE COMPLETATA', html: `L'operazione di acquisto
        è andata a buon fine.`
    }).then(function() {
        window.location.replace('../php/prodotti.php');
    });
</script>");
        break;
    case "annulla":
        $socio = $_GET["socio"];
        $prodotto = $_GET["prodotto"];
        $data = $_GET["data"];

        if ($prodotto == "tutti")
        {
            $sql = "SELECT nome_prodotto, SUM(qta) qta_tot FROM acquisto
                WHERE username_socio = $1 GROUP BY nome_prodotto";
            $ris = @pg_query_params($conn, $sql, array($socio));
            controllaRisultato($conn, $ris, "Si è verificato un errore interno nel
                database!\n Ci scusiamo per l'inconveniente...", false, "../php/prodotti.php");
            
            $qta_prodotti_acquistati = array();
            $row_num = 0;
            $record = @pg_fetch_array($ris, $row_num, PGSQL_ASSOC);

            while ($record)
            {
                $qta_prodotti_acquistati[$record["nome_prodotto"]] = intval(
                    $record["qta_tot"]);
                $record = @pg_fetch_array($ris, ++$row_num, PGSQL_ASSOC);
            }
            @pg_free_result($ris);
            $ris = @pg_query($conn, "BEGIN");
            @pg_free_result($ris);
            $sql = "DELETE FROM acquisto WHERE username_socio = $1";
            $ris = @pg_query_params($conn, $sql, array($socio));
            controllaRisultato($conn, $ris, "Si è verificato un errore interno nel
                database!\n Ci scusiamo per l'inconveniente...", true, "../php/prodotti.php");
            @pg_free_result($ris);
            $sql = "UPDATE prodotto SET qta_disponibile = ((SELECT qta_disponibile
                FROM prodotto WHERE nome = $1) + $2) WHERE nome = $3";
            foreach ($qta_prodotti_acquistati as $prodotto => $qta_acquistata)
            {
                $ris = @pg_query_params($conn, $sql,
                    array($prodotto, $qta_acquistata, $prodotto));
                controllaRisultato($conn, $ris, "Si è verificato un errore interno nel
                    database!\n Ci scusiamo per l'inconveniente...", true, "../php/prodotti.php");
                @pg_free_result($ris);
            }
            $ris = @pg_query($conn, "COMMIT");
            @pg_free_result($ris);
        }
        else
        {
            $sql = "SELECT qta FROM acquisto WHERE (username_socio, nome_prodotto, istante) =
                ($1, $2, $3)";
            $ris = @pg_query_params($conn, $sql, array($socio, $prodotto, $data));

            controllaRisultato($conn, $ris, "Si è verificato un errore interno nel
                database!\n Ci scusiamo per l'inconveniente...", false, "../php/prodotti.php");
            
            $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);
            $qta_prodotto_acquistato = intval($record["qta"]);

            @pg_free_result($ris);
            $ris = @pg_query($conn, "BEGIN");
            @pg_free_result($ris);
            $sql = "DELETE FROM acquisto
                WHERE (username_socio, nome_prodotto, istante) = ($1, $2, $3)";
            $ris = @pg_query_params($conn, $sql, array($socio, $prodotto, $data));
            controllaRisultato($conn, $ris, "Si è verificato un errore interno nel
                database!\n Ci scusiamo per l'inconveniente...", true, "../php/prodotti.php");
            @pg_free_result($ris);
            $sql = "UPDATE prodotto SET qta_disponibile = (SELECT qta_disponibile
                FROM prodotto WHERE nome = $1) + $2 WHERE nome = $3";
            $ris = @pg_query_params($conn, $sql, array($prodotto, $qta_prodotto_acquistato,
                $prodotto));
            controllaRisultato($conn, $ris, "Si è verificato un errore interno nel
                database!\n Ci scusiamo per l'inconveniente...", true, "../php/prodotti.php");
            $ris = @pg_query($conn, "COMMIT");
            @pg_free_result($ris);
            @pg_close($conn);
        }
        echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_successo', content: 'testo_successo',
        }, icon: 'success', title: 'OPERAZIONE COMPLETATA', html: `L'operazione di annullamento
        è andata a buon fine.`
    }).then(function() {
        window.location.replace('../php/carrello.php');
    });
</script>");
        break;
    }
?>
<!---->
    </main>
</body>
</html>