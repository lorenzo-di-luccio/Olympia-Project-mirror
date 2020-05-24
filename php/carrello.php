<?php
    session_start();
    include "connessione_db.php";
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olympia | Carrello</title>
    <link type="text/css" rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="../vendor/fontawesome/css/all.min.css">
    <link type="text/css" rel="stylesheet" href="../css/navbar.css">
    <link type="text/css" rel="stylesheet" href="../css/footer.css">
    <link type="text/css" rel="stylesheet" href="../css/carrello.css">
    <link type="text/css" rel="stylesheet" href="../css/swal.css">
    <script type="text/javascript" src="../vendor/jquery/jquery-3.4.1.slim.min.js"></script>
    <script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../vendor/fontawesome/js/all.min.js"></script>
    <script type="text/javascript" src="../vendor/sweetalert2/sweetalert2.min.js"></script>
    <script type="text/javascript" src="../js/navbar.js"></script>
    <script type="text/javascript" src="../js/footer.js"></script>
    <script type="text/javascript" src="../js/carrello.js"></script>
</head>

<body onload="creaNavbar(); impostaVoci(); azionaVocePrincipale('SHOP');">
    <header></header>
    <main>
        <h1 class="text-center">CARRELLO</h1>
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
        <p style='padding-bottom: 100%'></p>
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_errore', content: 'testo_errore',
        }, icon: 'error', title: 'SEI UN AMMINISTRATORE...', html: 'Non hai un carrello.'
    }).then(function() {
        window.location.replace('../html/index.html');
    });
</script>");
        exit(1);
    }
?>
        <div class="container text-center div_filtro_prodotto" id="div_prodotto_acquisti">
            <label for="prodotto_acquisti" class="label_filtro_prodotto" id="label_prodotto_acquisti">Prodotto</label>
            <br>
            <select id="prodotto_acquisti" class="custom-select" onchange="filtraProdottiAcquisti();">
                <option value="*" selected>*</option>
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT DISTINCT nome_prodotto FROM acquisto WHERE username_socio = $1";
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
            echo("<option value='" . $record["nome_prodotto"] . "'>" . $record["nome_prodotto"] . "</option>");
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
    <div class='container table-responsive' id='div_tabella_elenco'>
        <table class='table table-bordered table-light'>
            <thead class='thead-light'>
                <tr>
                    <th scope='col'>Prodotto</th>
                    <th scope='col'>Data/ora</th>
                    <th scope='col'>Quantità</th>
                    <th scope='col'>Prezzo</th>
                    <th scope='col'>Annulla</th>
                </tr>
            </thead>
            <tbody>");

    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT nome_prodotto, istante, qta, prezzo_da_pagare FROM acquisto
        WHERE username_socio = $1";
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
                    <td colspan='5'>Non ci sono prodotti nel tuo carrello...</td>
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
                <td>" . $record["nome_prodotto"] . "</td>
                <td>" . $record["istante"] . "</td>
                <td>" . $record["qta"] . "</td>
                <td>" . $record["prezzo_da_pagare"] . "</td>
                <td>
                    <a class='btn btn-sm btn-outline-danger bottone_annulla' href='#'>
                        <i class='fas fa-times-circle fa-2x'></i>
                    </a>
                </td>
            </tr>");
            $record = @pg_fetch_array($ris, ++$row_num, PGSQL_ASSOC);
        }
        echo("
                </tbody>
            </table>
        </div>");
        @pg_free_result($ris);
        @pg_close($conn);
        echo("
            <div class='text-center div_bottoni'>
                <a class='mt-3 btn btn-outline-danger' href='#'>Annulla tutto</a>
            </div>");
    }
?>
<script type="text/javascript">
    $(document).ready(function() {
        creaFooter();
        $(".bottone_annulla").on("click", function(ev) {
            ev.preventDefault();

            var username = sessionStorage["username"];
            var prodotto = $(this).parent().parent().children().first().html();
            var data = $(this).parent().parent().children().first().next().html();
            var qta = $(this).parent().parent().children().first().next().next().html();
            var prezzo = $(this).parent().parent().children().last().prev().html();

            Swal.fire({
                customClass: {
                    title: "titolo_domanda", content: "testo_domanda"
                }, showCancelButton: true, icon: "question", title: "ANNULLAMENTO ACQUISTO",
                html: `Sei sicuro/a di voler procedere annullando l'acquisto?<br>
                Questo è il prodotto scelto:<br>
                PRODOTTO: ` +  prodotto + `<br>
                QUANTITA': ` + qta + `<br>
                PREZZO: ` + prezzo + ``,
                confirmButtonText: "Sì", cancelButtonText: "No"
            }).then(function(confermato) {
                if (confermato.value)
                    window.location.replace("../php/acquisto_annulla.php?socio=" + sessionStorage["username"] + "&prodotto=" + prodotto + "&data=" + data + "&azione=annulla");
            });
        });
        $(".mt-3").on("click", function(ev) {
            ev.preventDefault();
            Swal.fire({
                customClass: {
                    title: "titolo_domanda", content: "testo_domanda"
                }, showCancelButton: true, icon: "question", title: "ANNULLAMENTO ACQUISTO",
                html: `Sei sicuro/a di voler procedere annullando tutti gli acquisti?`,
                confirmButtonText: "Sì", cancelButtonText: "No"
            }).then(function(confermato) {
                if (confermato.value)
                    window.location.replace("../php/acquisto_annulla.php?socio=" + sessionStorage["username"] + "&prodotto=tutti&data=2020&azione=annulla");
            });
        });
    });
</script>
    <div></div>
    </main>
</body>