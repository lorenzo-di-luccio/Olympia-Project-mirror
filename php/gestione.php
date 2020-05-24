<?php
    session_start();
    include "connessione_db.php";
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olympia | Gestione</title>
    <link type="text/css" rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="../vendor/fontawesome/css/all.min.css">
    <link type="text/css" rel="stylesheet" href="../css/navbar.css">
    <link type="text/css" rel="stylesheet" href="../css/footer.css">
    <link type="text/css" rel="stylesheet" href="../css/gestione.css">
    <link type="text/css" rel="stylesheet" href="../css/swal.css">
    <script type="text/javascript" src="../vendor/jquery/jquery-3.4.1.slim.min.js"></script>
    <script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../vendor/fontawesome/js/all.min.js"></script>
    <script type="text/javascript" src="../vendor/sweetalert2/sweetalert2.min.js"></script>
    <script type="text/javascript" src="../js/navbar.js"></script>
    <script type="text/javascript" src="../js/footer.js"></script>
    <script type="text/javascript" src="../js/gestione.js"></script>
</head>
<body onload="creaNavbar(); impostaVoci(); azionaVocePrincipale('GESTIONE');">
    <header></header>
    <main>
<?php
    if (! isset($_SESSION["loggato"]) || ! $_SESSION["loggato"])
    {
        echo("
        <h1 class='text-center'>GESTIONE</h1>
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
?>
        <nav class="navbar navbar-expand-md navbar-light sticky-top bg-light" id="navbar_gestione">
            <ul class="nav nav-pills ml-auto mr-auto" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#pane_APPROVAZIONI" role="tab" data-toggle="tab">Approvazioni</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#pane_CAMBIO_ABBONAMENTI" role="tab" data-toggle="tab">Cambio abbonamenti</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#pane_VENDITE" role="tab" data-toggle="tab">Vendite</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#pane_AGGIORNAMENTO_PRODOTTI" role="tab" data-toggle="tab">Aggiornamento prodotti</a>
                </li>
            </ul>
        </nav>
        <div class="tab-content" id="contenuto_navbar_gestione" data-spy="scroll" data-target="#navbar_gestione">
            <div class="tab-pane active" id="pane_APPROVAZIONI">
                <h1 class="text-center" id="APPROVAZIONI">APPROVAZIONI</h1>
                <div class="container text-center div_filtro" id="div_socio_approvazioni">
                    <label for="socio_approvazioni" class="label_filtro" id="label_socio_approvazioni">Socio</label>
                    <br>
                    <select id="socio_approvazioni" class="custom-select" onchange="filtraSociApprovazioni();">
                        <option value="*" selected>*</option>
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../php/gestione.php");

    $sql = "SELECT username FROM utente WHERE approvato = false ORDER BY username";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../php/gestione.php");
    
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
            echo("<option value='@" . $record["username"] . "'>" . "@" . $record["username"] . "</option>");
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
    <div class='container table-responsive' id='div_approvazioni'>
                <table class='table table-bordered table-light'>
                    <thead class='thead-light'>
                        <tr>
                            <th scope='col'>Username</th>
                            <th scope='col'>Nome</th>
                            <th scope='col'>Cognome</th>
                            <th scope='col'>Email</th>
                            <th scope='col'>Abbonamento</th>
                            <th scope='col'>Approva</th>
                            <th scope='col'>Rifiuta</th>
                        </tr>
                    </thead>
                    <tbody>");
    
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../php/gestione.php");

    $sql = "SELECT username, nome, cognome, email, abbonamento FROM utente
        WHERE approvato = false ORDER BY username";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../php/gestione.php");
    
    $row_num = 0;
    $record = @pg_fetch_array($ris, $row_num, PGSQL_ASSOC);
    if (! $record)
    {
        @pg_free_result($ris);
        @pg_close($conn);
        echo("
                    <tr>
                        <td colspan='7'>Non ci sono soci da approvare...</td>
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
                <td>@" . $record["username"] . "</td>
                <td>" . $record["nome"] . "</td>
                <td>" . $record["cognome"] . "</td>
                <td>" . $record["email"] . "</td>
                <td>" . $record["abbonamento"] . "</td>
                <td>
                    <a class='btn btn-sm btn-outline-success bottone_approva' href='../php/approvazione_rifiuto.php?username=" . $record["username"] . "&azione=approva'>
                        <i class='fas fa-check-circle fa-2x'></i>
                    </a>
                </td>
                <td>
                    <a class='btn btn-sm btn-outline-danger bottone_rifiuta' href='../php/approvazione_rifiuto.php?username=" . $record["username"] . "&azione=rifiuta'>
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
            <a class='mt-3 btn btn-outline-success' href='../php/approvazione_rifiuto.php?username=tutti&azione=approva'>Approva tutti</a>
            <a class='mt-3 btn btn-outline-danger' href='../php/approvazione_rifiuto.php?username=tutti&azione=rifiuta'>Rifiuta tutti</a>
        </div>");
    }
?>
            </div>
            <div class="tab-pane" id="pane_CAMBIO_ABBONAMENTI">
                <h1 class="text-center" id="CAMBIO_ABBONAMENTI">CAMBIO ABBONAMENTI</h1>
                <div class="container text-center div_filtro" id="div_socio_abbonamenti">
                    <label for="socio_abbonamenti" class="label_filtro" id="label_socio_abbonamenti">Socio</label>
                    <br>
                    <select id="socio_abbonamenti" class="custom-select" onchange="filtraSociAbbonamenti();">
                        <option value="*" selected>*</option>
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../php/gestione.php");

    $sql = "SELECT username FROM utente WHERE ruolo = 'socio' ORDER BY username";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../php/gestione.php");
    
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
            echo("<option value='@" . $record["username"] . "'>" . "@" . $record["username"] . "</option>");
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
    <form name='form_cambio_abbonamenti' id='form_cambio_abbonamenti' method='POST' action='../php/cambio_abbonamenti.php'>
        <div class='container table-responsive' id='div_cambio_abbonamenti'>
            <table class='table table-bordered table-light'>
                <thead class='thead-light'>
                    <tr>
                        <th scope='col'>Socio</th>
                        <th scope='col'>Abbonamento</th>
                        <th scope='col'>Data di scadenza</th>
                        <th scope='col'>Cambia</th>
                    </tr>
                </thead>
                <tbody>");
    
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../php/gestione.php");

    $sql = "SELECT username, abbonamento, data_scadenza FROM utente WHERE ruolo = 'socio'
        ORDER BY username";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../php/gestione.php");
    
    $row_num = 0;
    $record = @pg_fetch_array($ris, $row_num, PGSQL_ASSOC);

    while ($record)
    {
        $abbonamento = $record["abbonamento"];

        echo("
        <tr>
            <td>
                <input type='text' class='form-control' name='?' value='@" . $record["username"] . "' readonly></input>
            </td>
            <td>
                <select class='custom-select' name='?'>");
        if ($abbonamento == "*")
            echo("<option value='*' selected>*</option>");
        else
            echo("<option value='*'>*</option>");
        if ($abbonamento == "-")
            echo("<option value='-' selected>-</option>");
        else
            echo("<option value='-'>-</option>");
        if ($abbonamento == "Crossfit")
            echo("<option value='Crossfit' selected>Crossfit</option>");
        else
            echo("<option value='Crossfit'>Crossfit</option>");
        if ($abbonamento == "Bodybuilding")
            echo("<option value='Bodybuilding' selected>Bodybuilding</option>");
        else
            echo("<option value='Bodybuilding'>Bodybuilding</option>");
        if ($abbonamento == "Pesistica")
            echo("<option value='Pesistica' selected>Pesistica</option>");
        else
            echo("<option value='Pesistica'>Pesistica</option>");
        if ($abbonamento == "Crossfit & Bodybuilding")
            echo("<option value='Crossfit & Bodybuilding' selected>Crossfit & Bodybuilding</option>");
        else
            echo("<option value='Crossfit & Bodybuilding'>Crossfit & Bodybuilding</option>");
        if ($abbonamento == "Crossfit & Pesistica")
            echo("<option value='Crossfit & Pesistica' selected>Crossfit & Pesistica</option>");
        else
            echo("<option value='Crossfit & Pesistica'>Crossfit & Pesistica</option>");
        if ($abbonamento == "Bodybuilding & Pesistica")
            echo("<option value='Bodybuilding & Pesistica' selected>Bodybuilding & Pesistica</option>");
        else
            echo("<option value='Bodybuilding & Pesistica'>Bodybuilding & Pesistica</option>");
        echo("
                </select>
            </td>
            <td>
                <input type='date' class='form-control' name='?' value='" . $record["data_scadenza"] . "'></input>
            </td>
            <td>
                <button type='submit' class='btn btn-sm btn-outline-success bottone_cambia' name='bottone_cambia'>
                    <i class='fas fa-check-circle fa-2x'></i>
                </button>
            </td>
        </tr>");
        $record = @pg_fetch_array($ris, ++$row_num, PGSQL_ASSOC);
    }
    echo("
                </tbody>
            </table>
        </div>
        <div class='container text-center div_bottoni'>
            <button type='reset' name='bottone_reset' class='mt-3 btn btn-outline-danger'>Reset</button>
        </div>
    </form>
    ");
    @pg_free_result($ris);
    @pg_close($conn);
?>
            </div>
            <div class="tab-pane" id="pane_VENDITE">
                <h1 class="text-center" id="VENDITE">VENDITE</h1>
                <div class="container text-center div_filtro" id="div_socio_vendite">
                    <label for="socio_vendite" class="label_filtro" id="label_socio_vendite">Socio</label>
                    <br>
                    <select id="socio_vendite" class="custom-select" onchange="filtraSociVendite();">
                        <option value="*" selected>*</option>
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../php/gestione.php");

    $sql = "SELECT DISTINCT username_socio FROM acquisto";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../php/gestione.php");
    
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
            echo("<option value='@" . $record["username_socio"] . "'>" . "@" . $record["username_socio"] . "</option>");
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
    <div class='container table-responsive' id='div_vendite'>
                <table class='table table-bordered table-light'>
                    <thead class='thead-light'>
                        <tr>
                            <th scope='col'>Socio</th>
                            <th scope='col'>Prodotto</th>
                            <th scope='col'>Data/ora</th>
                            <th scope='col'>Quantità</th>
                            <th scope='col'>Prezzo</th>
                            <th scope='col'>Vendi</th>
                            <th scope='col'>Recedi</th>
                        </tr>
                    </thead>
                    <tbody>");
    
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../php/gestione.php");

    $sql = "SELECT * FROM acquisto";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../php/gestione.php");
    
    $row_num = 0;
    $record = @pg_fetch_array($ris, $row_num, PGSQL_ASSOC);
    if (! $record)
    {
        @pg_free_result($ris);
        @pg_close($conn);
        echo("
                    <tr>
                        <td colspan='7'>Non ci sono prodotti da vendere...</td>
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
                <td>@" . $record["username_socio"] . "</td>
                <td>" . $record["nome_prodotto"] . "</td>
                <td>" . $record["istante"] . "</td>
                <td>" . $record["qta"] . "</td>
                <td>" . $record["prezzo_da_pagare"] . "</td>
                <td>
                    <a class='btn btn-sm btn-outline-success bottone_vendi' href='../php/vendita_recesso.php?socio=" . $record["username_socio"] . "&prodotto=" . $record["nome_prodotto"] . "&data=" . $record["istante"] . "&azione=vendi'>
                        <i class='fas fa-check-circle fa-2x'></i>
                    </a>
                </td>
                <td>
                    <a class='btn btn-sm btn-outline-danger bottone_recedi' href='../php/vendita_recesso.php?socio=" . $record["username_socio"] . "&prodotto=" . $record["nome_prodotto"] . "&data=" . $record["istante"] . "&azione=recedi'>
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
            <a class='mt-3 btn btn-outline-success' href='../php/vendita_recesso.php?socio=tutti&azione=vendi'>Vendi tutto</a>
            <a class='mt-3 btn btn-outline-danger' href='../php/vendita_recesso.php?socio=tutti&azione=recedi'>Recedi tutto</a>
        </div>");
    }
?>
            </div>
            <div class="tab-pane" id="pane_AGGIORNAMENTO_PRODOTTI">
                <h1 class="text-center" id="AGGIORNAMENTO PRODOTTI">AGGIORNAMENTO PRODOTTI</h1>
                <div class="container text-center div_filtro" id="div_aggiornamento_prodotti">
                    <label for="aggiornamento_prodotti" class="label_filtro" id="label_aggiornamento_prodotti">Prodotto</label>
                    <br>
                    <select id="aggiornamento_prodotti" class="custom-select" onchange="filtraProdottiAggiornamento();">
                        <option value="*" selected>*</option>
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../php/gestione.php");

    $sql = "SELECT nome FROM prodotto ORDER BY nome";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../php/gestione.php");
    
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
            echo("<option value='" . $record["nome"] . "'>" . $record["nome"] . "</option>");
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
    <div class='container table-responsive' id='div_aggiornamento_prodotti'>
                <table class='table table-bordered table-light'>
                    <thead class='thead-light'>
                        <tr>
                            <th scope='col'>Prodotto</th>
                            <th scope='col'>Quantità disponibile</th>
                            <th scope='col'>Aggiungi</th>
                            <th scope='col'>Rimuovi</th>
                        </tr>
                    </thead>
                    <tbody>");
    
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../php/gestione.php");

    $sql = "SELECT nome, qta_disponibile FROM prodotto ORDER BY nome";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../php/gestione.php");
    
    $row_num = 0;
    $record = @pg_fetch_array($ris, $row_num, PGSQL_ASSOC);
    while ($record)
    {
        echo("
        <tr>
            <td>" . $record["nome"] . "</td>
            <td>" . $record["qta_disponibile"] . "</td>
            <td>
                <input type='number' min='0' max='99' step='1'></input>
                <p>\t</p>
                <a class='btn btn-sm btn-outline-success bottone_aggiungi' href='#'>
                    <i class='fas fa-plus-circle fa-2x'></i>
                </a>
            </td>
            <td>
                <input type='number' min='0' max='" . $record["qta_disponibile"] . "' step='1'></input>
                <p>\t</p>
                <a class='btn btn-sm btn-outline-danger bottone_rimuovi' href='#'>
                    <i class='fas fa-minus-circle fa-2x'></i>
                </a>
            </td>
        </tr>");
        $record = @pg_fetch_array($ris, ++$row_num, PGSQL_ASSOC);
    }
    echo("
            </tbody>
        </table>
    </div>
    <div class='div_bottoni'><p hidden></p></div>
    ");
    @pg_free_result($ris);
    @pg_close($conn);
?>
            </div>
        </div>
<script type="text/javascript">
    $(document).ready(function() {
        creaFooter();
        $(".bottone_aggiungi").on("click", function(ev) {
            ev.preventDefault();

            var prodotto = $(this).parent().parent().children().first().html();
            var qta = $(this).parent().parent().children().first().next().html();
            var qtaPiu = $(this).parent().children().first().val();

            if (qtaPiu == "" || qtaPiu == "0")
                return;
            Swal.fire({
                customClass: {
                    title: "titolo_domanda", content: "testo_domanda"
                }, showCancelButton: true, icon: "question", title: "AGGIUNTA PRODOTTO",
                html: `Sei sicuro di voler procedere?<br>
                Questo è il cambiamento che stai per fare:<br>
                PRODOTTO: ` + prodotto + `<br>
                QUANTITA': ` + qta + ` -> ` + (parseInt(qta) + parseInt(qtaPiu)) + ``,
                confirmButtonText: "Sì", cancelButtonText: "No"
            }).then(function(confermato) {
                if (confermato.value)
                    window.location.replace("../php/aggiunta_rimozione.php?prodotto=" + prodotto + "&qtaPiu=" + qtaPiu + "&azione=aggiungi");
            });
        });
        $(".bottone_rimuovi").on("click", function(ev) {
            ev.preventDefault();

            var prodotto = $(this).parent().parent().children().first().html();
            var qta = $(this).parent().parent().children().first().next().html();
            var qtaMeno = $(this).parent().children().first().val();

            if (qtaMeno == "" || qtaMeno == "0")
                return;
            Swal.fire({
                customClass: {
                    title: "titolo_domanda", content: "testo_domanda"
                }, showCancelButton: true, icon: "question", title: "RIMOZIONE PRODOTTO",
                html: `Sei sicuro di voler procedere?<br>
                Questo è il cambiamento che stai per fare:<br>
                PRODOTTO: ` + prodotto + `<br>
                QUANTITA': ` + qta + ` -> ` + (parseInt(qta) - parseInt(qtaMeno)) + ``,
                confirmButtonText: "Sì", cancelButtonText: "No"
            }).then(function(confermato) {
                if (confermato.value)
                    window.location.replace("../php/aggiunta_rimozione.php?prodotto=" + prodotto + "&qtaMeno=" + qtaMeno + "&azione=rimuovi");
            });
        });
        $("#form_cambio_abbonamenti").on("submit", function(ev) {
            ev.preventDefault();

            var socio = $("#form_cambio_abbonamenti input[name=socio]").val();
            var abbonamento = $("#form_cambio_abbonamenti select[name=abbonamento] option:selected").val();
            var dataScadenza = $("#form_cambio_abbonamenti input[name=data_scadenza]").val();

            Swal.fire({
                customClass: {
                    title: "titolo_domanda", content: "testo_domanda"
                }, showCancelButton: true, icon: "question", title: "CAMBIO ABBONAMENTI",
                html: `Sei sicuro di voler procedere cambiando al seguente socio l'abbonamento 
                in questo modo?<br>
                Questo è il cambiamento che stai per fare:<br>
                SOCIO: ` + socio + `<br>
                ABBONAMENTO: ` + abbonamento + `<br>
                DATA DI SCADENZA: ` + dataScadenza.split("-").reverse().join("/") + ``,
                confirmButtonText: "Sì", cancelButtonText: "No"
            }).then(function(confermato) {
                if (confermato.value)
                    $("#form_cambio_abbonamenti").off("submit").submit();
            });
        });
    });
</script>
    <div></div>
    </main>
</body>
</html>