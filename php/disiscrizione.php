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
    <title>Olympia | Disiscrizione</title>
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
    <script type="text/javascript" src="../js/session_storage.js"></script>
</head>
<body onload="creaNavbar(); impostaVoci(); azionaVocePrincipale('DISISCRIZIONE')">
    <!--Navbar-->
    <header></header>
    <!---->
    <main>
        <h1 class="text-center">DISISCRIZIONE</h1>
<!--Controlla che ci sia un utente loggato. Se non c'è, visualizza un alert con il corrispondente
messaggio di errore. Se non ci sono errori, procede con la disiscrizione effettuando una DELETE
sul database. Se tutto è andato a buon fine, visualizza un alert che avverte del successo
dell'operazione e che reindirizza all'home page.-->
<?php
    if (! isset($_SESSION["loggato"]) || ! $_SESSION["loggato"])
    {
        echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_errore', content: 'testo_errore',
        }, icon: 'error', title: 'NON SEI REGISTRATO...', html: 'Non puoi disiscriverti.'
    }).then(function() {
        window.location.replace('../html/login.html');
    });
</script>");
        exit(1);
    }
    
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "DELETE FROM utente WHERE username = $1";
    $ris = @pg_query_params($conn, $sql, array($_SESSION["username"]));

    controllaRisultato($conn, $ris, "Trovate prenotazioni e/o acquisti a tuo nome in sospeso!
        Risolvi prima di procedere.", false, "../html/index.html");
    @pg_free_result($ris);
    @pg_close($conn);
    echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_successo', content: 'testo_successo',
        }, icon: 'success', title: 'DISISCRIZIONE COMPLETATA',
        html: `Ti sei disiscritto/a...<br> Queste erano le tue credenziali principali:<br>
        NOME: " . $_SESSION["nome"] . "<br>
        COGNOME: " . $_SESSION["cognome"] . "<br>
        USERNAME: @" . $_SESSION["username"] . "`,
    }).then(function() {
        ripristinaSessionStorage();
        window.location.replace('../html/index.html');
    });
</script>");
?>
<!---->
    </main>
</body>
</html>