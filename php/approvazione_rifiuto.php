<?php
    session_start();
    include "connessione_db.php";
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olympia | Approvazione - Rifiuto</title>
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
<body onload="creaNavbar(); impostaVoci(); azionaVocePrincipale('GESTIONE');">
    <header></header>
    <main>
        <h1 class='text-center'>APPROVAZIONE - RIFIUTO</h1>
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
    case "approva":
        $sql = "UPDATE utente SET approvato = true WHERE username ";
        if ($_GET["username"] == "tutti")
        {
            $sql .= "IN (SELECT username FROM utente WHERE approvato = false)";
            $ris = @pg_query($conn, $sql);
        }
        else
        {
            $sql .= "= $1";
            $ris = @pg_query_params($conn, $sql, array($_GET["username"]));
        }
        controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
            Ci scusiamo per l'inconveniente...", false, "../php/gestione.php");
        @pg_free_result($ris);
        @pg_close($conn);
        echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_successo', content: 'testo_successo'
        }, icon: 'success', title: 'OPERAZIONE COMPLETATA', html: `L'operazione di approvazione
        è andata a buon fine.`,
    }).then(function() {
        window.location.replace('../php/gestione.php');
    });
</script>");
        break;
    case "rifiuta":
        $sql = "DELETE FROM utente WHERE username ";
        if ($_GET["username"] == "tutti")
        {
            $sql .= "IN (SELECT username FROM utente WHERE approvato = false)";
            $ris = @pg_query($conn, $sql);
        }
        else
        {
            $sql .= "= $1";
            $ris = @pg_query_params($conn, $sql, array($_GET["username"]));
        }
        controllaRisultato($conn, $ris, "Trovate prenotazioni e/o acquisti a nome di questo
            socio in sospeso! Risolvere prima di procedere.", false, "../php/gestione.php");
        @pg_free_result($ris);
        @pg_close($conn);
        echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_successo', content: 'testo_successo'
        }, icon: 'success', title: 'OPERAZIONE COMPLETATA', html: `L'operazione di rifiuto
        è andata a buon fine.`,
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