<?php
    session_start();
    include "connessione_db.php";
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olympia | Vendita - Recesso</title>
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
<body onload="creaNavbar(); impostaVoci(); azionaVocePrincipale('GESTIONE');">
    <header></header>
    <main>
        <h1 class="text-center">VENDITA - RECESSO</h1>
<?php
    if (! isset($_SESSION["loggato"]) || ! $_SESSION["loggato"])
    {
        echo("
        <p style='padding-bottom: 100%'></p>
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_errore', content: 'testo_errore',
        }, icon: 'error', title: 'NON SEI REGISTRATO...', html: 'Effettua il login.'
    }).then(function() {
        window.location.replace('../html/login.html');
    });
</script>");
        exit(1);
    }
    if ($_SESSION["ruolo"] != "admin")
    {
        echo("
        <p style='padding-bottom: 100%'></p>
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_errore', content: 'testo_errore',
        }, icon: 'error', title: 'SEI UN SOCIO...', html: 'Non hai un accesso a questa pagina.'
    }).then(function() {
        window.location.replace('../html/index.html');
    });
</script>");
        exit(1);
    }
    if (! isset($_GET["azione"]))
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

    controllaConnessione($conn, "../php/gestione.php");

    $sql;
    $ris;

    switch ($_GET["azione"])
    {
        case "vendi":
            $sql = "DELETE FROM acquisto";
            if ($_GET["socio"] == "tutti")
            {
                $ris = @pg_query($conn, $sql);
                @pg_free_result($ris);
            }
            else
            {
                $sql .= " WHERE (username_socio, nome_prodotto, istante) = ($1, $2, $3)";
                $ris = @pg_query_params($conn, $sql, array($_GET["socio"], $_GET["prodotto"],
                    $_GET["data"]));
                controllaRisultato($conn, $ris, "Si è verificato un errore interno nel
                    database!\n Ci scusiamo per l'inconveniente...", false, "../php/gestione.php");
                @pg_free_result($ris);
            }
            @pg_close($conn);
            echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_successo', content: 'testo_successo',
        }, icon: 'success', title: 'OPERAZIONE COMPLETATA', html: `L'operazione di vendita
        è andata a buon fine.`
    }).then(function() {
        window.location.replace('../php/gestione.php');
    });
</script>");
            break;
        case "recedi":
            $sql = "SELECT nome_prodotto, SUM(qta) qta_tot FROM acquisto";
            if ($_GET["socio"] == "tutti")
            {
                $sql .= " GROUP BY nome_prodotto";
                $ris = @pg_query($conn, $sql);
                controllaRisultato($conn, $ris, "Si è verificato un errore interno nel
                    database!\n Ci scusiamo per l'inconveniente...", false, "../php/gestione.php");
                
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
                $sql = "DELETE FROM acquisto";
                $ris = @pg_query($conn, $sql);
                controllaRisultato($conn, $ris, "Si è verificato un errore interno nel
                    database!\n Ci scusiamo per l'inconveniente...", true, "../php/gestione.php");
                @pg_free_result($ris);
                $sql = "UPDATE prodotto SET qta_disponibile = ((SELECT qta_disponibile
                    FROM prodotto WHERE nome = $1) + $2) WHERE nome = $3";
                foreach ($qta_prodotti_acquistati as $prodotto => $qta_acquistata)
                {
                    $ris = @pg_query_params($conn, $sql,
                        array($prodotto, $qta_acquistata, $prodotto));
                    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel
                        database!\n Ci scusiamo per l'inconveniente...", true, "../php/gestione.php");
                    @pg_free_result($ris);
                }
                $ris = @pg_query($conn, "COMMIT");
                @pg_free_result($ris);
            }
            else
            {
                $socio = $_GET["socio"];
                $prodotto = $_GET["prodotto"];
                $data = $_GET["data"];

                $sql .= " WHERE (username_socio, nome_prodotto, istante) = ($1, $2, $3)
                    GROUP BY nome_prodotto";
                $ris = @pg_query_params($conn, $sql, array($socio, $prodotto, $data));
                controllaRisultato($conn, $ris, "Si è verificato un errore interno nel
                    database!\n Ci scusiamo per l'inconveniente...", false, "../php/gestione.php");
                
                $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);
                $qta_prodotto_acquistato = intval($record["qta_tot"]);

                @pg_free_result($ris);
                $ris = @pg_query($conn, "BEGIN");
                @pg_free_result($ris);
                $sql = "DELETE FROM acquisto
                    WHERE (username_socio, nome_prodotto, istante) = ($1, $2, $3)";
                $ris = @pg_query_params($conn, $sql, array($socio, $prodotto, $data));
                controllaRisultato($conn, $ris, "Si è verificato un errore interno nel
                    database!\n Ci scusiamo per l'inconveniente...", true, "../php/gestione.php");
                @pg_free_result($ris);
                $sql = "UPDATE prodotto SET qta_disponibile = (SELECT qta_disponibile
                    FROM prodotto WHERE nome = $1) + $2 WHERE nome = $3";
                $ris = @pg_query_params($conn, $sql, array($prodotto, $qta_prodotto_acquistato,
                    $prodotto));
                controllaRisultato($conn, $ris, "Si è verificato un errore interno nel
                    database!\n Ci scusiamo per l'inconveniente...", true, "../php/gestione.php");
                $ris = @pg_query($conn, "COMMIT");
                @pg_free_result($ris);
            }
            @pg_close($conn);
            echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_successo', content: 'testo_successo',
        }, icon: 'success', title: 'OPERAZIONE COMPLETATA', html: `L'operazione di recesso
        è andata a buon fine.`
    }).then(function() {
        window.location.replace('../php/gestione.php');
    });
</script>");
            break;
    }
?>
    </main>
</body>
</html>