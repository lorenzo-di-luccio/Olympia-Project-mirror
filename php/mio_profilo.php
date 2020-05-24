<?php
    session_start();
    include "connessione_db.php";
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olympia | Il mio profilo</title>
    <link type="text/css" rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="../vendor/fontawesome/css/all.min.css">
    <link type="text/css" rel="stylesheet" href="../css/navbar.css">
    <link type="text/css" rel="stylesheet" href="../css/footer.css">
    <link type="text/css" rel="stylesheet" href="../css/mio_profilo.css">
    <link type="text/css" rel="stylesheet" href="../css/swal.css">
    <script type="text/javascript" src="../vendor/jquery/jquery-3.4.1.slim.min.js"></script>
    <script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../vendor/fontawesome/js/all.min.js"></script>
    <script type="text/javascript" src="../vendor/sweetalert2/sweetalert2.min.js"></script>
    <script type="text/javascript" src="../js/navbar.js"></script>
    <script type="text/javascript" src="../js/footer.js"></script>
</head>
<body onload="creaNavbar(); impostaVoci(); azionaVocePrincipale('UTENTE');">
    <header></header>
    <main>
        <h1 class="text-center">IL MIO PROFILO</h1>
<?php
    if (! isset($_SESSION["loggato"]) || ! $_SESSION["loggato"])
    {
        echo("
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
    echo("
    <form name='form_cambio_profilo' id='form_cambio_profilo' method='POST' action='../php/cambio_profilo.php'>
        <div class='container table-responsive' id='tabella_mio_profilo'>
            <table class='table table-bordered table-light'>
                <tbody>");
    
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT email, username, ruolo FROM utente WHERE username = $1";
    $ris = @pg_query_params($conn, $sql, array($_SESSION["username"]));

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");
    
    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);
    
    controllaRecord($conn, $ris, $record, "Si è verificato un errore interno nel database!\n
    Ci scusiamo per l'inconveniente...", "../html/index.html");
    echo("
                <tr>
                    <td>Email: </td>
                    <td><input type='email' name='email' class='form-control' value='" . $record["email"] . "'></input></td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td><input type='text' name='username' class='form-control' value='" . $record["username"] . "'></input></td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td><input type='password' name='password' class='form-control' value=''></input></td>
                </tr>
                <tr>
                    <td>Conferma password: </td>
                    <td><input type='password' name='conferma_password' class='form-control' value=''></input></td>
                </tr>
            </tbody>
        </table>
    </div>
        ");
        @pg_free_result($ris);
        @pg_close($conn);
        echo("
        <div class='container text-center div_bottoni'>
            <button type='submit' name='bottone_cambia' class='mt-3 btn btn-outline-success'>Cambia</button>
            <button type='reset' name='bottone_reset' class='mt-3 btn btn-outline-danger'>Reset</button>
        </div>
    </form>");
?>
<script type="text/javascript">
    $(document).ready(function() {
        creaFooter();
        $("#form_cambio_profilo").on("submit", function(ev) {
            ev.preventDefault();

            if ($("#form_cambio_profilo input[name=password]").val() !=
                $("#form_cambio_profilo input[name=conferma_password]").val())
            {
                Swal.fire({
                customClass: {
                    title: "titolo_warning", content: "testo_warning"
                }, icon: "warning", title: "MODIFICA PROFILO",
                html: `Le password non corrispondono`,
                });
                return false;
            }

            var email = $("#form_cambio_profilo input[name=email]").val();
            var username = $("#form_cambio_profilo input[name=username]").val();

            Swal.fire({
                customClass: {
                    title: "titolo_domanda", content: "testo_domanda"
                }, showCancelButton: true, icon: "question", title: "MODIFICA PROFILO",
                html: `Sei sicuro/a di voler procedere modificando il tuo profilo?<br>
                Questo sarà il tuo nuovo profilo:<br>
                EMAIL: ` +  email + `<br>
                USERNAME: ` + username + ``,
                confirmButtonText: "Sì", cancelButtonText: "No"
            }).then(function(confermato) {
                if (confermato.value)
                    $("#form_cambio_profilo").off("submit").submit();
            });
            return false;
        });
    });
</script>
    </main>
</body>
</html>