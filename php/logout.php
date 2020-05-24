<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olympia | Logout</title>
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
    <header></header>
    <main>
        <h1 class="text-center">LOGOUT</h1>
<?php
    if (! isset($_SESSION["loggato"]) || ! $_SESSION["loggato"])
    {
        echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_errore', content: 'testo_errore',
        }, icon: 'error', title: 'NON SEI LOGGATO...', html: 'Non puoi effettuare il logout.'
    }).then(function() {
        window.location.replace('../html/login.html');
    });
</script>");
        exit(1);
    }
    session_unset();
    session_destroy();
?>
<script type="text/javascript">
    $(document).ready(function() {
        ripristinaSessionStorage();
        window.location.replace("../html/index.html");
    });
</script>
    </main>
</body>
</html>