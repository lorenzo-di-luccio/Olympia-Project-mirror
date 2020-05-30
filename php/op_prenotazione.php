<!--Riprende la sessione PHP iniziata o ne crea una nuova.-->
<?php
    session_start();
    include "connessione_db.php"
?>
<!---->
<!--PAGINA DI TRANSIZIONE-->
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olympia | Prenotazione</title>
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
<body onload="creaNavbar(); impostaVoci(); azionaVocePrincipale('ORARIO');">
    <!--Navbar-->
    <header></header>
    <!---->
    <main>
        <h1 class="text-center">PRENOTAZIONE</h1>
        <p style="padding-bottom: 100%"></p>
<!--Controlla, in ordine, che ci sia un utente loggato, che l'utente loggato sia un socio e che la
pagina sia stata chiamata con il metodo GET o con il metodo POST. Se almeno una delle tre
condizioni non viene soddisfatta, visualizza un alert con il corrispondente messaggio di errore.
Se non ci sono errori, procede o con la prenotazione o con la disdetta di una prenotazione ad un
corso effettuando sul database le operazioni opportune. Se tutto è andato a buon fine, visualizza
un alert che avverte del successo dell'operazione e che, appena chiuso, reindirizza o alla pagina
di prenotazione o alla pagina dei miei corsi.-->
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
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_errore', content: 'testo_errore',
        }, icon: 'error', title: 'SEI UN AMMINISTRATORE...', html: 'Non puoi prenotarti a
        nessun corso e/o disdirne le prenotazioni.'
    }).then(function() {
        window.location.replace('../html/index.html');
    });
</script>");
    }
    if ((! isset($_GET["azione"]) && ! isset($_POST["corso"])))
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

    controllaConnessione($conn, "../php/prenotazione.php");

    $sql;
    $ris;

    if (! isset($_GET["azione"]))
    {
        $sql = "SELECT abbonamento FROM utente WHERE username = $1";
        $ris = @pg_query_params($conn, $sql, array($_SESSION["username"]));

        controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../php/prenotazione.php");

        $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);
        $abbonamento = $record["abbonamento"];
        @pg_free_result($ris);

        $corso = explode(" - ", $_POST["corso"])[0];
        switch ($abbonamento)
        {
        case "Crossfit":
        case "Bodybuilding":
        case "Pesistica":
            if ($corso != $abbonamento)
            {
                echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_errore', content: 'testo_errore',
        }, icon: 'error', title: 'CI DISPIACE...', html: `Il tuo abbonamento non ti permette di
        iscriverti a questo corso...`
    }).then(function() {
        window.location.replace('../php/prenotazione.php');
    });
</script>");
                exit(1);
            }
            break;
        case "Crossfit & Bodybuilding":
        case "Crossfit & Pesistica":
        case "Bodybuilding & Pesistica":
            $corsiAbbonamento = explode(" & ", $abbonamento);
            if ($corso != $corsiAbbonamento[0] && $corso != $corsiAbbonamento[1])
            {
                echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_errore', content: 'testo_errore',
        }, icon: 'error', title: 'CI DISPIACE...', html: `Il tuo abbonamento non ti permette di
        iscriverti a questo corso...`
    }).then(function() {
        window.location.replace('../php/prenotazione.php');
    });
</script>");
                exit(1);
            }
            break;
        case "-":
            echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_errore', content: 'testo_errore',
        }, icon: 'error', title: 'INCREDIBILE...', html: `Non sei abbonato a nulla...`
    }).then(function() {
        window.location.replace('../html/login.html');
    });
</script>");
            break;
        case "*":
            break;
        }
        $ris = @pg_query($conn, "BEGIN");
        @pg_free_result($ris);
        $sql = "INSERT INTO prenotazione VALUES($1, $2,
            (SELECT (num_posti_prenotati + 1) FROM corso WHERE nome = $3), now())";
        $ris = @pg_query_params($conn, $sql, array($_SESSION["username"], $_POST["corso"],
            $_POST["corso"]));
        controllaRisultato($conn, $ris, "Non puoi prenotarti di nuovo a questo corso.",
            true, "../php/prenotazione.php");
        @pg_free_result($ris);
        $sql = "UPDATE corso SET (num_posti_rimasti, num_posti_prenotati) =
            (num_posti_rimasti - 1, num_posti_prenotati + 1) WHERE nome = $1";
        $ris = @pg_query_params($conn, $sql, array($_POST["corso"]));
        controllaRisultato($conn, $ris, "Non puoi prenotarti a questo corso perché il numero di
            posti disponibili è esaurito.", true, "../php/prenotazione.php");
        $ris = @pg_query($conn, "COMMIT");
        @pg_free_result($ris);
        @pg_close($conn);
        echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_successo', content: 'testo_successo',
        }, icon: 'success', title: 'OPERAZIONE COMPLETATA',
        html: `L'operazione di prenotazione è andata a buon fine.`,
    }).then(function() {
        window.location.replace('../php/prenotazione.php');
    });
</script>");
    }
    else
    {
        if ($_GET["corso"] == "tutti")
        {
            $ris = @pg_query($conn, "BEGIN");
            @pg_free_result($ris);
            $sql = "UPDATE prenotazione SET numero = numero - 1
                WHERE (username_socio, nome_corso) IN
                (SELECT DISTINCT p1.username_socio, p1.nome_corso
                FROM prenotazione p1 JOIN prenotazione p2 ON p1.username_socio <> $1
                WHERE p1.nome_corso IN (SELECT nome_corso FROM prenotazione
                WHERE username_socio = $2) AND p1.numero > p2.numero)";
            $ris = @pg_query_params($conn, $sql, array($_SESSION["username"],
                $_SESSION["username"]));
            controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
            Ci scusiamo per l'inconveniente...", true, "../php/miei_corsi.php");
            @pg_free_result($ris);
            $sql = "UPDATE corso
                SET (num_posti_rimasti, num_posti_prenotati) = (num_posti_rimasti + 1,
                num_posti_prenotati - 1) WHERE nome IN (SELECT nome_corso FROM prenotazione
                WHERE username_socio = $1)";
            $ris = @pg_query_params($conn, $sql, array($_SESSION["username"]));
            controllaRisultato($conn, $ris, "", true, "../php/miei_corsi.php");
            @pg_free_result($ris);
            $sql = "DELETE FROM prenotazione WHERE username_socio = $1";
            $ris = @pg_query_params($conn, $sql, array($_SESSION["username"]));
            @pg_free_result($ris);
            $ris = @pg_query($conn, "COMMIT");
            @pg_free_result($ris);
        }
        else
        {
            $ris = @pg_query($conn, "BEGIN");
            @pg_free_result($ris);
            $sql = "UPDATE prenotazione SET numero = numero - 1 WHERE nome_corso = $1 AND
                numero > (SELECT numero FROM prenotazione WHERE (username_socio, nome_corso) =
                ($2, $3))";
            $ris = @pg_query_params($conn, $sql, array($_GET["corso"], $_SESSION["username"],
                $_GET["corso"]));
            controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
            Ci scusiamo per l'inconveniente...", true, "../php/miei_corsi.php");
            @pg_free_result($ris);
            $sql = "UPDATE corso SET (num_posti_rimasti, num_posti_prenotati) =
                (num_posti_rimasti + 1, num_posti_prenotati - 1) WHERE nome = $1";
            $ris = @pg_query_params($conn, $sql, array($_GET["corso"]));
            controllaRisultato($conn, $ris, "", true, "../php/miei_corsi.php");
            @pg_free_result($ris);
            $sql = "DELETE FROM prenotazione WHERE (username_socio, nome_corso) = ($1, $2)";
            $ris = @pg_query_params($conn, $sql, array($_SESSION["username"], $_GET["corso"]));
            @pg_free_result($ris);
            $ris = @pg_query($conn, "COMMIT");
            @pg_free_result($ris);
        }
        @pg_close($conn);
        echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_successo', content: 'testo_successo',
        }, icon: 'success', title: 'OPERAZIONE COMPLETATA',
        html: `L'operazione di disdetta è andata a buon fine.`,
    }).then(function() {
        window.location.replace('../php/miei_corsi.php');
    });
</script>");
    }
?>
<!---->
    </main>
</body>
</html>