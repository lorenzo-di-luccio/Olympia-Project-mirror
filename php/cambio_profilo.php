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
    <title>Olympia | Cambio profilo</title>
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
<body onload="creaNavbar(); impostaVoci(); azionaVocePrincipale('UTENTE');">
    <!--Navbar-->
    <header></header>
    <!---->
    <main>
        <h1 class="text-center">ACQUISTO - ANNULLA</h1>
<!--Controlla, in ordine, che ci sia un utente loggato e che la pagina sia stata chiamata con il
metodo POST. Se almeno una delle due condizioni non viene soddisfatta, visualizza un alert con il
corrispondente messaggio di errore. Se non ci sono errori, procede con il cambio del profilo per
l'utente loggato effettuando sul database le operazioni opportune. Se tutto è andato a buon fine,
visualizza un alert che avverte del successo dell'operazione e che, appena chiuso, reindirizza
alla pagina di logout.-->
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
    if (! isset($_POST["username"]))
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
    $sql;
    $ris;

    controllaConnessione($conn, "../php/mio_profilo.php");

    if ($_POST["password"] == "")
    {
        $sql = "UPDATE utente SET (email, username) = ($1, $2)
            WHERE username = $3";
        $ris = @pg_query_params($conn, $sql, array($_POST["email"], $_POST["username"],
            $_SESSION["username"]));
    }
    else
    {
        $sql = "UPDATE utente SET (email, username, password) = ($1, $2, $3)
            WHERE username = $4";
        $ris = @pg_query_params($conn, $sql, array($_POST["email"], $_POST["username"],
            $_POST["password"], $_SESSION["username"]));
    }

    controllaRisultato($conn, $ris, "Trovate prenotazioni e/o acquisti a tuo nome in sospeso!
        Risolvi prima di procedere.", false, "../php/mio_profilo.php");
    @pg_free_result($ris);
    @pg_close($conn);
    echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_successo', content: 'testo_successo',
        }, icon: 'success', title: 'OPERAZIONE COMPLETATA', html: `L'operazione di cambio del
        profilo è andata a buon fine.`
    }).then(function() {
        window.location.replace('../php/logout.php');
    });
</script>");
?>
<!---->
    </main>
</body>
</html>