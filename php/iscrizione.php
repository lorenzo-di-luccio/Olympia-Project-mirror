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
    <title>Olympia | Iscrizione</title>
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
    <script type="text/javascript" src="../js/iscrizione.js"></script>
</head>
<body onload="creaNavbar(); impostaVoci(); azionaVocePrincipale('ISCRIZIONE');">
    <!--Navbar-->
    <header></header>
    <!---->
    <main>
        <h1 class="text-center">ISCRIZIONE</h1>
<!--Controlla, in ordine, che non ci sia un utente loggato e che la pagina sia stata chiamata con
il metodo POST. Se almeno una delle due condizioni non viene soddisfatta, visualizza un alert con
il corrispondente messaggio di errore. Se non ci sono errori, procede con l'iscrizione
effettuando una INSERT sul database. Se tutto è andato a buon fine, visualizza un alert che
avverte del successo dell'operazione e che reindirizza all'home page.-->
<?php
    if (isset($_SESSION["loggato"]) && $_SESSION["loggato"])
    {
        echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_errore', content: 'testo_errore'
        }, icon: 'error', title: 'SEI LOGGATO...', html: 'Sei già iscritto...'
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
            title: 'titolo_errore', content: 'testo_errore'
        }, icon: 'error', title: 'ERRORE...', html: 'Accesso negato!'
    }).then(function() {
        window.location.replace('../html/index.html');
    });
</script>");
        exit(1);
    }

    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/iscrizione.html");

    $sql = "INSERT INTO utente VALUES($1, $2, $3, $4, $5, $6, $7, false, 'socio', $8, now())";
    $ris = @pg_query_params($conn, $sql, array($_POST["username"], $_POST["password"],
        $_POST["nome"], $_POST["cognome"], $_POST["data_nascita"], $_POST["sesso"],
        $_POST["email"], $_POST["abbonamento"]));
    
    controllaRisultato($conn, $ris, "Username già esistente!", false, "../html/iscrizione.html");
    $_SESSION["iscritto"] = true;
    $_SESSION["username"] = $_POST["username"];
    $_SESSION["nome"] = $_POST["nome"];
    $_SESSION["cognome"] = $_POST["cognome"];
    @pg_free_result($ris);
    @pg_close($conn);
    echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_successo', content: 'testo_successo'
        }, icon: 'success', title: 'ISCRIZIONE COMPLETATA', html: `Ti sei iscritto con le
            seguenti credenziali:<br>
            NOME: " . $_POST["nome"] . "<br>
            COGNOME: " . $_POST["cognome"] . "<br>
            DATA DI NASCITA: " . implode("/",
                array_reverse(explode("-", $_POST["data_nascita"]))) . "<br>
            SESSO: " . $_POST["sesso"] . "<br>
            USERNAME: " . $_POST["username"] . "<br>
            ABBONAMENTO: " . $_POST["abbonamento"] . "<br>Recati in una nostra palestra per
            l'approvazione e poi effettua il login per poter utilizzare il sito.`,
    }).then(function() {
        window.location.replace('../html/index.html');
    });
</script>");
?>
<!---->
    </main>
</body>
</html>