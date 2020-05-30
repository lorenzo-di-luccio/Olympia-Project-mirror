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
    <title>Olympia | Login</title>
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
<body onload="creaNavbar(); impostaVoci(); azionaVocePrincipale('UTENTE');">
    <!--Navbar-->
    <header></header>
    <!---->
    <main>
        <h1 class="text-center">LOGIN</h1>
<!--Controlla, in ordine, che non ci sia un utente loggato e che la pagina sia stata chiamata con
il metodo POST. Se almeno una delle due condizioni non viene soddisfatta, visualizza un alert con
il corrispondente messaggio di errore. Se non ci sono errori, procede con il login effettuando
due SELECT sul database. Se tutto è andato a buon fine, visualizza un alert che avverte del
successo dell'operazione e che, appena chiuso, scrive sul Session Storage i dati dell'utente
loggato reindirizza all'home page.-->
<?php
    if (isset($_SESSION["loggato"]) && $_SESSION["loggato"])
    {
        echo("
    <script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_errore', content: 'testo_errore'
        }, icon: 'error', title: 'SEI LOGGATO...', html: 'Puoi già utilizzare il sito...'
    }).then(function() {
        window.location.replace('../html/index.html');
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

    controllaConnessione($conn, "../html/login.html");

    $sql = "SELECT nome, cognome, approvato, ruolo FROM utente WHERE username = $1";
    $ris = @pg_query_params($conn, $sql, array($_POST["username"]));

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
    Ci scusiamo per l'inconveniente...", false, "../html/login.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    controllaRecord($conn, $ris, $record, "Username errato!", "../html/login.html");
    @pg_free_result($ris);
    $sql = "SELECT nome, cognome, approvato, ruolo FROM utente WHERE username = $1 AND
        password = $2";
    $ris = @pg_query_params($conn, $sql, array($_POST["username"], $_POST["password"]));
    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
    Ci scusiamo per l'inconveniente...", false, "../html/login.html");
    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    controllaRecord($conn, $ris, $record, "Password errata!", "../html/login.html");
    $_SESSION["loggato"] = true;
    $_SESSION["username"] = $_POST["username"];
    $_SESSION["nome"] = $record["nome"];
    $_SESSION["cognome"] = $record["cognome"];
    $_SESSION["approvato"] = $record["approvato"];
    $_SESSION["ruolo"] = $record["ruolo"];
    @pg_free_result($ris);
    @pg_close($conn);

    $testoTitolo = $_SESSION["ruolo"] == "socio" ? "BENTORATO/A @" . $_SESSION["username"] . "!"
        : "BENTORNATO/A CAPO @" . $_SESSION["username"] . "!";
    $testoBenvenuto = $_SESSION["approvato"] == "t" ? "Ora puoi utilizzare al meglio il sito."
        : "Recati in una nostra palestra per l\'approvazione.";

    echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_successo', content: 'testo_successo',
        }, icon: 'success', title: '" . $testoTitolo . "',
        html: '" . $testoBenvenuto . "',
    }).then(function() {
        impostaSessionStorage('t', '" . $_SESSION["username"] . "',
            '" . $_SESSION["approvato"] . "', '" . $_SESSION["ruolo"] . "', 't');
        window.location.replace('../html/index.html');
    });
</script>");
?>
<!---->
    </main>
</body>
</html>