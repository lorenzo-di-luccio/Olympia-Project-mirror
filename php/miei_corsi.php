<?php
    session_start();
    include "connessione_db.php";
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olympia | I miei corsi</title>
    <link type="text/css" rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="../vendor/fontawesome/css/all.min.css">
    <link type="text/css" rel="stylesheet" href="../css/navbar.css">
    <link type="text/css" rel="stylesheet" href="../css/footer.css">
    <link type="text/css" rel="stylesheet" href="../css/miei_corsi.css">
    <link type="text/css" rel="stylesheet" href="../css/swal.css">
    <script type="text/javascript" src="../vendor/jquery/jquery-3.4.1.slim.min.js"></script>
    <script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../vendor/fontawesome/js/all.min.js"></script>
    <script type="text/javascript" src="../vendor/sweetalert2/sweetalert2.min.js"></script>
    <script type="text/javascript" src="../js/navbar.js"></script>
    <script type="text/javascript" src="../js/footer.js"></script>
    <script type="text/javascript" src="../js/miei_corsi.js"></script>
</head>
<body onload="creaNavbar(); impostaVoci(); azionaVocePrincipale('UTENTE');">
    <header></header>
    <main>
        <h1 class="text-center">I MIEI CORSI</h1>
        <div class="container text-center div_filtro_corsi" id="div_miei_corsi">
            <label for="miei_corsi" class="label_filtro_corsi" id="label_div_corsi">Corso</label>
            <br>
            <select id="miei_corsi" class="custom-select" onchange="filtraMieiCorsi();">
                <option value="*" selected>*</option>
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
    if ($_SESSION["ruolo"] != "socio")
    {
        echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_errore', content: 'testo_errore',
        }, icon: 'error', title: 'SEI UN AMMINISTRATORE...', html: 'Non puoi prenotarti ai corsi.'
    }).then(function() {
        window.location.replace('../html/index.html');
    });
</script>");
        exit(1);
    }

    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT nome_corso FROM prenotazione WHERE username_socio = $1 ORDER BY istante";
    $ris = @pg_query_params($conn, $sql, array($_SESSION["username"]));

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");
    
    $row_num = 0;
    $record = @pg_fetch_array($ris, $row_num, PGSQL_ASSOC);
    if (! $record)
    {
        @pg_free_result($ris);
        @pg_close($conn);
    }
    else
    {
        while ($record)
        {
            echo("<option value='" . $record["nome_corso"] . "'>" . $record["nome_corso"] . "</option>");
            $record = @pg_fetch_array($ris, ++$row_num, PGSQL_ASSOC);
        }
        @pg_free_result($ris);
        @pg_close($conn);
    }
?>
            </select>
        </div>
<?php
    echo("
    <div class='container table-responsive' id='tabella_miei_corsi'>
        <table class='table table-bordered table-light'>
            <thead class='thead-light'>
                <tr>
                    <th scope='col'>Corso</th>
                    <th scope='col'>Numero prenotazione</th>
                    <th scope='col'>Data</th>
                    <th scope='col'>Disdici</th>
                </tr>
            </thead>
            <tbody>");
    
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT nome_corso, numero, istante FROM prenotazione WHERE username_socio = $1
        ORDER BY istante";
    $ris = @pg_query_params($conn, $sql, array($_SESSION["username"]));

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");
    
    $row_num = 0;
    $record = @pg_fetch_array($ris, $row_num, PGSQL_ASSOC);
    if (! $record)
    {
        @pg_free_result($ris);
        @pg_close($conn);
        echo("
                    <tr>
                        <td colspan='4'>Non ci sono corsi a cui sei prenotato/a...</td>
                    </tr>
                </tbody>
            </table>
        </div>");
    }
    else
    {
        while ($record)
        {
            echo("
            <tr>
                <td>" . $record["nome_corso"] . "</td>
                <td>" . $record["numero"] . "</td>
                <td>" . $record["istante"] . "</td>
                <td>
                    <a class='btn btn-sm btn-outline-danger bottone_disdici' href='#'>
                        <i class='fas fa-times-circle fa-2x'></i>
                    </a>
                </td>
            </tr>");
            $record = @pg_fetch_array($ris, ++$row_num, PGSQL_ASSOC);
        }
        echo("
                </tbody>
            </table>
        </div>
        ");
        @pg_free_result($ris);
        @pg_close($conn);
        echo("
        <div class='text-center div_bottoni'>
            <a class='mt-3 btn btn-outline-danger' href='#'>Disdici tutti</a>
        </div>");
    }
?>
<script type="text/javascript">
    $(document).ready(function() {
        creaFooter();
        $(".bottone_disdici").on("click", function(ev) {
            ev.preventDefault();

            var corso = $(this).parent().parent().children().first().html();

            Swal.fire({
                customClass: {
                    title: "titolo_domanda", content: "testo_domanda"
                }, showCancelButton: true, icon: "question", title: "DISDETTA PRENOTAZIONE CORSO",
                html: `Sei sicuro/a di voler procedere disdicendo?<br>
                Questo è il corso scelto:<br>
                CORSO: ` +  corso + ``,
                confirmButtonText: "Sì", cancelButtonText: "No"
            }).then(function(confermato) {
                if (confermato.value)
                    window.location.replace("../php/op_prenotazione.php?corso=" + corso + "&azione=disdici");
            });
        });
        $(".mt-3").on("click", function(ev) {
            ev.preventDefault();
            Swal.fire({
                customClass: {
                    title: "titolo_domanda", content: "testo_domanda"
                }, showCancelButton: true, icon: "question", title: "DISDETTA PRENOTAZIONE CORSO",
                html: `Sei sicuro/a di voler procedere disdicendo tutte le prenotazioni ai corsi?<br>`,
                confirmButtonText: "Sì", cancelButtonText: "No"
            }).then(function(confermato) {
                if (confermato.value)
                    window.location.replace("../php/op_prenotazione.php?corso=tutti&azione=disdici");
            });
        });
    });
</script>
    </main>
</body>
</html>