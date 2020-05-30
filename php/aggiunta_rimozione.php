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
    <title>Olympia | Aggiunta - Rimozione</title>
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
    <!--Navbar-->
    <header></header>
    <!---->
    <main>
        <h1 class="text-center">AGGIUNTA - RIMOZIONE</h1>
<!--Controlla, in ordine, che ci sia un utente loggato, che l'utente loggato sia un
amministratore e che la pagina sia stata chiamata con il metodo GET. Se almeno una delle tre
condizioni non viene soddisfatta, visualizza un alert con il corrispondente messaggio di errore.
Se non ci sono errori, procede o con l'aggiunta o con la rimozione di una determinata quantità
di un prodotto effettuando sul database le operazioni opportune. Se tutto è andato a buon fine,
visualizza un alert che avverte del successo dell'operazione e che, appena chiuso, reindirizza
alla pagina di gestione.-->
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
    if (! isset($_GET["prodotto"]))
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
    case "aggiungi":
        $qtaPiu = intval($_GET["qtaPiu"]);
        $sql = "UPDATE prodotto SET qta_disponibile = (SELECT (qta_disponibile + $1)
            FROM prodotto WHERE nome = $2) WHERE nome = $3";
        $ris = @pg_query_params($conn, $sql, array($qtaPiu, $_GET["prodotto"],
            $_GET["prodotto"]));

        controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
            Ci scusiamo per l'inconveniente...", false, "../php/gestione.php");
        @pg_free_result($ris);
        @pg_close($conn);
        echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_successo', content: 'testo_successo',
        }, icon: 'success', title: 'OPERAZIONE COMPLETATA', html: `L'operazione di aggiunta di
        un prodotto è andata a buon fine.`
    }).then(function() {
        window.location.replace('../php/gestione.php');
    });
</script>");
        break;
    case "rimuovi":
        $qtaMeno = intval($_GET["qtaMeno"]);
        $sql = "UPDATE prodotto SET qta_disponibile = (SELECT (qta_disponibile - $1)
            FROM prodotto WHERE nome = $2) WHERE nome = $3";
        $ris = @pg_query_params($conn, $sql, array($qtaMeno, $_GET["prodotto"],
            $_GET["prodotto"]));

        controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
            Ci scusiamo per l'inconveniente...", false, "../php/gestione.php");
        @pg_free_result($ris);
        @pg_close($conn);
        echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_successo', content: 'testo_successo',
        }, icon: 'success', title: 'OPERAZIONE COMPLETATA', html: `L'operazione di rimozione di
        un prodotto è andata a buon fine.`
    }).then(function() {
        window.location.replace('../php/gestione.php');
    });
</script>");
        break;
    }
?>
<!---->
    </main>
</body>
</html>