<!--Riprende la sessione PHP iniziata o ne crea una nuova.-->
<?php
    session_start();
    include "connessione_db.php";
?>
<!---->
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olympia | Prodotti</title>
    <link type="text/css" rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="../vendor/fontawesome/css/all.min.css">
    <link type="text/css" rel="stylesheet" href="../css/navbar.css">
    <link type="text/css" rel="stylesheet" href="../css/footer.css">
    <link type="text/css" rel="stylesheet" href="../css/prodotti.css">
    <link type="text/css" rel="stylesheet" href="../css/swal.css">
    <script type="text/javascript" src="../vendor/jquery/jquery-3.4.1.slim.min.js"></script>
    <script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../vendor/fontawesome/js/all.min.js"></script>
    <script type="text/javascript" src="../vendor/sweetalert2/sweetalert2.min.js"></script>
    <script type="text/javascript" src="../js/navbar.js"></script>
    <script type="text/javascript" src="../js/footer.js"></script>
    <script type="text/javascript" src="../js/prodotti.js"></script>
</head>
<body onload="creaNavbar(); impostaVoci(); azionaVocePrincipale('SHOP');">
    <!--Navbar-->
    <header></header>
    <!---->
    <main>
        <!--Cover con prodotto-->
        <section>
        <div class="container-fluid pseudo-carousel">
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-3 col-md-6 text-center">
                    <h1 class="stile-scritta text-center">RAGGIUNGI IL TUO MASSIMO</h1>
                    <p class="text-center stile-scritta3">
                        Spingiti oltre i tuoi limiti con i prodotti CapacityX
                    </p>
                    <button type="button" class="btn btn-outline-dark btn-lg" data-toggle="modal" data-target="#proteina">
                        ACQUISTA ORA
                    </button>
                </div>
                <div class="col-lg-7 col-md-6 text-center">
                    <img src="../img/proteina1.jpg" id="logo1" alt="">
                </div>
            </div>
            <div class="row">
                <div class="col-md text-center">
                    <a class="container-freccetta" href="#BOMBE">
                        <span><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                    </a>
                </div>
            </div>
        </div>
        </section>
        <!---->
        <!--La nostra vetrina-->
        <div class="container-fluid sfondo" id="BOMBE">
            <div class="row big-padding">
                <div class="container">
                    <h3 class="stile-scritta2 text-center">LA NOSTRA VETRINA</h3>
                </div>
            </div>
            <div class="row" id="vet1">
                <div class="col-md-4 text-center">
                    <img src="../img/bcaacapsules.jpg" id="logo2" alt="">
                    <p class="padding-btn">
                        <button type="button" class="btn btn-outline-dark btn-lg" data-toggle="modal" data-target="#bcaa">
                            Acquista
                        </button>
                    </p>
                </div>
                <div class="col-md-4 text-center"> 
                    <img src="../img/cookies&cream.jpg" id="logo2" alt="">
                    <p class="padding-btn">
                        <button type="button" class="btn btn-outline-dark btn-lg" data-toggle="modal" data-target="#cookie1">
                            Acquista
                        </button>
                    </p>
                </div>
                <div class="col-md-4 text-center">
                    <img src="../img/cookies&cream2.jpg" id="logo2" alt="">
                    <p class="padding-btn">
                        <button type="button" class="btn btn-outline-dark btn-lg" data-toggle="modal" data-target="#cookie2">
                            Acquista
                        </button>
                    </p>
                </div>
            </div>
            <div class="row" id="vet2">
                <div class="col-md-4 text-center"> 
                    <img src="../img/maglia.jpg" id="logo2" alt="">
                    <p class="padding-btn">
                        <button type="button" class="btn btn-outline-dark btn-lg" data-toggle="modal" data-target="#t-shirt">
                            Acquista
                        </button>
                    </p>
                </div>
                <div class="col-md-4 text-center"> 
                    <img src="../img/borsa.jpg" id="logo2" alt="">
                    <p class="padding-btn">
                        <button type="button" class="btn btn-outline-dark btn-lg" data-toggle="modal" data-target="#borsa">
                            Acquista
                        </button>
                    </p>
                </div>
                <div class="col-md-4 text-center"> 
                    <img src="../img/cover.jpg" id="logo2" alt="">
                    <p class="padding-btn">
                        <button type="button" class="btn btn-outline-dark btn-lg" data-toggle="modal" data-target="#cover">
                            Acquista
                        </button>
                    </p>
                </div>
            </div>
        </div>
        <!---->
        <!--Serie di modal. Uno per ogni prodotto. Sono anche delle form.-->
        <div class="modal fade" id="proteina"  style="top:30%; ">
            <div class="modal-dialog ">
                <div class="modal-content" style=" background:#20303c;">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <div class="container text-center">
                            <img src="../img/proteina1.jpg" id="logo3">
                        </div>
                        <form id="acquista_CX_Pre_Workout" method="POST" action="../php/acquisto_annulla.php?azione=acquista">
                            <input type="text" name="nome_prodotto" value="CX Pre Workout" hidden>
                            <label class="stile-scritta3">Quantità:</label>
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../php/prodotti.php");

    $sql = "SELECT qta_disponibile FROM prodotto WHERE nome = 'CX Pre Workout 25g'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
    Ci scusiamo per l'inconveniente...", false, "../php/prodotti.php");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);
    $qta_disponibile = $record["qta_disponibile"];

    echo("<input type='number' class='form-control mb-3' id='CX_Pre_Workout_25g' name='quantita25g' min='0' max='" .
        $qta_disponibile . "' step='1'>");
    @pg_free_result($ris);
    $sql = "SELECT qta_disponibile FROM prodotto WHERE nome = 'CX Pre Workout 70g'";
    $ris = @pg_query($conn, $sql);
    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
    Ci scusiamo per l'inconveniente...", false, "../php/prodotti.php");
    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);
    $qta_disponibile = $record["qta_disponibile"];
    echo("<input type='number' class='form-control mb-3' id='CX_Pre_Workout_70g' name='quantita70g' min='0' max='" .
        $qta_disponibile . "' step='1' hidden>");
    @pg_free_result($ris);
    @pg_close($conn);
?>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md text-center">
                                        <p class="stile-scritta3"><input type="radio" onclick="controllaPreWorkout();" name="versione" value="25g" checked>25g</p>
                                    </div>
                                    <div class="col-md text-center">
                                        <p class="stile-scritta3"><input type="radio" onclick="controllaPreWorkout();" name="versione" value="70g">70g</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md text-center">
                                        <button class="btn btn-outline-light" type="submit">PROCEDI ALL'ACQUISTO</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="bcaa" style="top:30%;">
            <div class="modal-dialog">
                <div class="modal-content" style=" background:#20303c;">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <div class="container text-center">
                            <img src="../img/bcaacapsules.jpg" id="logo3">
                        </div>
                        <form id="acquista_CX_BCAA_Capsules" method="POST" action="../php/acquisto_annulla.php?azione=acquista">
                            <input type="text" name="nome_prodotto" value="CX BCCA Capsules" hidden>
                            <label class="stile-scritta3">Quantità:</label>
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../php/prodotti.php");

    $sql = "SELECT qta_disponibile FROM prodotto WHERE nome = 'CX BCCA Capsules 60c'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
    Ci scusiamo per l'inconveniente...", false, "../php/prodotti.php");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);
    $qta_disponibile = $record["qta_disponibile"];

    echo("<input type='number' class='form-control mb-3' id='CX_BCAA_Capsules_60c' name='quantita60c' min='0' max='" .
        $qta_disponibile . "' step='1'>");
    @pg_free_result($ris);
    $sql = "SELECT qta_disponibile FROM prodotto WHERE nome = 'CX BCCA Capsules 200c'";
    $ris = @pg_query($conn, $sql);
    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
    Ci scusiamo per l'inconveniente...", false, "../php/prodotti.php");
    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);
    $qta_disponibile = $record["qta_disponibile"];
    echo("<input type='number' class='form-control mb-3' id='CX_BCAA_Capsules_200c' name='quantita200c' min='0' max='" .
        $qta_disponibile . "' step='1' hidden>");
    @pg_free_result($ris);
    @pg_close($conn);
?>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md text-center">
                                        <p class="stile-scritta3"><input type="radio" onclick="controllaBCAACapsules();" name="versione" value="60c" checked>60c</p>
                                    </div>
                                    <div class="col-md text-center">
                                        <p class="stile-scritta3"><input type="radio" onclick="controllaBCAACapsules();" name="versione" value="200c">200c</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md text-center">
                                        <button class="btn btn-outline-light" type="submit">PROCEDI ALL'ACQUISTO</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="cookie1" style="top:30%;">
            <div class="modal-dialog">
                <div class="modal-content" style=" background:#20303c;">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <div class="container text-center">
                            <img src="../img/cookies&cream.jpg" id="logo3">
                        </div>
                        <form id="acquista_CX_Protein_Powder" method="POST" action="../php/acquisto_annulla.php?azione=acquista">
                            <input type="text" name="nome_prodotto" value="CX Protein Powder" hidden>
                            <label class="stile-scritta3">Quantità:</label>
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../php/prodotti.php");

    $sql = "SELECT qta_disponibile FROM prodotto WHERE nome = 'CX Protein Powder 25g'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
    Ci scusiamo per l'inconveniente...", false, "../php/prodotti.php");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);
    $qta_disponibile = $record["qta_disponibile"];

    echo("<input type='number' class='form-control mb-3' id='CX_Protein_Powder_25g' name='quantita25g' min='0' max='" .
        $qta_disponibile . "' step='1'>");
    @pg_free_result($ris);
    $sql = "SELECT qta_disponibile FROM prodotto WHERE nome = 'CX Protein Powder 70g'";
    $ris = @pg_query($conn, $sql);
    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
    Ci scusiamo per l'inconveniente...", false, "../php/prodotti.php");
    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);
    $qta_disponibile = $record["qta_disponibile"];
    echo("<input type='number' class='form-control mb-3' id='CX_Protein_Powder_70g' name='quantita70g' min='0' max='" .
        $qta_disponibile . "' step='1' hidden>");
    @pg_free_result($ris);
    @pg_close($conn);
?>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md text-center">
                                        <p class="stile-scritta3"><input type="radio" onclick="controllaProteinPowder();" name="versione" value="25g" checked>25g</p>
                                    </div>
                                    <div class="col-md text-center">
                                        <p class="stile-scritta3"><input type="radio" onclick="controllaProteinPowder();" name="versione" value="70g">70g</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md text-center">
                                        <button class="btn btn-outline-light" type="submit">PROCEDI ALL'ACQUISTO</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="cookie2" style="top:30%; " >
            <div class="modal-dialog">
                <div class="modal-content" style=" background:#20303c;">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <div class="container text-center">
                            <img src="../img/cookies&cream2.jpg" id="logo3">
                        </div>
                        <form id="acquista_CX_Protein_Powder2" method="POST" action="../php/acquisto_annulla.php?azione=acquista">
                            <input type="text" name="nome_prodotto" value="CX Protein Powder" hidden>
                            <label class="stile-scritta3">Quantità:</label>
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../php/prodotti.php");

    $sql = "SELECT qta_disponibile FROM prodotto WHERE nome = 'CX Protein Powder 25g'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
    Ci scusiamo per l'inconveniente...", false, "../php/prodotti.php");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);
    $qta_disponibile = $record["qta_disponibile"];

    echo("<input type='number' class='form-control mb-3' id='CX_Protein_Powder2_25g' name='quantita25g' min='0' max='" .
        $qta_disponibile . "' step='1'>");
    @pg_free_result($ris);
    $sql = "SELECT qta_disponibile FROM prodotto WHERE nome = 'CX Protein Powder 70g'";
    $ris = @pg_query($conn, $sql);
    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
    Ci scusiamo per l'inconveniente...", false, "../php/prodotti.php");
    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);
    $qta_disponibile = $record["qta_disponibile"];
    echo("<input type='number' class='form-control mb-3' id='CX_Protein_Powder2_70g' name='quantita70g' min='0' max='" .
        $qta_disponibile . "' step='1' hidden>");
    @pg_free_result($ris);
    @pg_close($conn);
?>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md text-center">
                                        <p class="stile-scritta3"><input type="radio" onclick="controllaProteinPowder2();" name="versione" value="25g" checked>25g</p>
                                    </div>
                                    <div class="col-md text-center">
                                        <p class="stile-scritta3"><input type="radio" onclick="controllaProteinPowder2();" name="versione" value="70g">70g</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md text-center">
                                        <button class="btn btn-outline-light" type="submit">PROCEDI ALL'ACQUISTO</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="t-shirt" style="top:30%; " >
            <div class="modal-dialog">
                <div class="modal-content" style=" background:#20303c;">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <div class="container text-center">
                            <img src="../img/maglia.jpg" id="logo3">
                        </div>
                        <form id="acquista_T-Shirt_Olympia" method="POST" action="../php/acquisto_annulla.php?azione=acquista">
                            <input type="text" name="nome_prodotto" value="T-Shirt Olympia" hidden>
                            <label class="stile-scritta3">Quantità:</label>
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../php/prodotti.php");

    $sql = "SELECT qta_disponibile FROM prodotto WHERE nome = 'T-Shirt Olympia XS'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
    Ci scusiamo per l'inconveniente...", false, "../php/prodotti.php");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);
    $qta_disponibile = $record["qta_disponibile"];

    echo("<input type='number' class='form-control mb-3' id='T-Shirt_Olympia_XS' name='quantitaXS' min='0' max='" .
        $qta_disponibile . "' step='1'>");
    @pg_free_result($ris);
    $sql = "SELECT qta_disponibile FROM prodotto WHERE nome = 'T-Shirt Olympia S'";
    $ris = @pg_query($conn, $sql);
    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
    Ci scusiamo per l'inconveniente...", false, "../php/prodotti.php");
    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);
    $qta_disponibile = $record["qta_disponibile"];
    echo("<input type='number' class='form-control mb-3' id='T-Shirt_Olympia_S' name='quantitaS' min='0' max='" .
        $qta_disponibile . "' step='1' hidden>");
    @pg_free_result($ris);
    $sql = "SELECT qta_disponibile FROM prodotto WHERE nome = 'T-Shirt Olympia M'";
    $ris = @pg_query($conn, $sql);
    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
    Ci scusiamo per l'inconveniente...", false, "../php/prodotti.php");
    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);
    $qta_disponibile = $record["qta_disponibile"];
    echo("<input type='number' class='form-control mb-3' id='T-Shirt_Olympia_M' name='quantitaM' min='0' max='" .
        $qta_disponibile . "' step='1' hidden>");
    @pg_free_result($ris);
    $sql = "SELECT qta_disponibile FROM prodotto WHERE nome = 'T-Shirt Olympia L'";
    $ris = @pg_query($conn, $sql);
    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
    Ci scusiamo per l'inconveniente...", false, "../php/prodotti.php");
    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);
    $qta_disponibile = $record["qta_disponibile"];
    echo("<input type='number' class='form-control mb-3' id='T-Shirt_Olympia_L' name='quantitaL' min='0' max='" .
        $qta_disponibile . "' step='1' hidden>");
    @pg_free_result($ris);
    $sql = "SELECT qta_disponibile FROM prodotto WHERE nome = 'T-Shirt Olympia XL'";
    $ris = @pg_query($conn, $sql);
    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
    Ci scusiamo per l'inconveniente...", false, "../php/prodotti.php");
    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);
    $qta_disponibile = $record["qta_disponibile"];
    echo("<input type='number' class='form-control mb-3' id='T-Shirt_Olympia_XL' name='quantitaXL' min='0' max='" .
        $qta_disponibile . "' step='1' hidden>");
    @pg_free_result($ris);
    @pg_close($conn);
?>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md text-center">
                                        <p class="stile-scritta3"><input type="radio" onclick="controllaTShirt();" name="versione" value="XS" checked>XS</p>
                                    </div>
                                    <div class="col-md text-center">
                                        <p class="stile-scritta3"><input type="radio" onclick="controllaTShirt();" name="versione" value="S">S</p>
                                    </div>
                                    <div class="col-md text-center">
                                        <p class="stile-scritta3"><input type="radio" onclick="controllaTShirt();" name="versione" value="M">M</p>
                                    </div>
                                    <div class="col-md text-center">
                                        <p class="stile-scritta3"><input type="radio" onclick="controllaTShirt();" name="versione" value="L">L</p>
                                    </div>
                                    <div class="col-md text-center">
                                        <p class="stile-scritta3"><input type="radio" onclick="controllaTShirt();" name="versione" value="XL">XL</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md text-center">
                                        <button type="submit" class="btn btn-outline-light" value="Procedi all'acquisto">PROCEDI ALL'ACQUISTO</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="borsa" style="top:30%; " >
            <div class="modal-dialog">
                <div class="modal-content" style=" background:#20303c;">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <div class="container text-center">
                            <img src="../img/borsa.jpg" id="logo3">
                        </div>
                        <form id="acquista_Borsa_Olympia" method="POST" action="../php/acquisto_annulla.php?azione=acquista">
                            <input type="text" name="nome_prodotto" value="Borsa Olympia" hidden>
                            <label class="stile-scritta3">Quantità:</label>
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../php/prodotti.php");

    $sql = "SELECT qta_disponibile FROM prodotto WHERE nome = 'Borsa Olympia'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
    Ci scusiamo per l'inconveniente...", false, "../php/prodotti.php");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);
    $qta_disponibile = $record["qta_disponibile"];

    echo("<input type='number' class='form-control mb-3' id='Borsa_Olympia' name='quantita' min='0' max='" .
        $qta_disponibile . "' step='1'>");
    @pg_free_result($ris);
    @pg_close($conn);
?>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md text-center">
                                        <button class="btn btn-outline-light" type="submit">PROCEDI ALL'ACQUISTO</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="cover" style="top:30%; " >
            <div class="modal-dialog">
                <div class="modal-content" style=" background:#20303c;">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <div class="container text-center">
                            <img src="../img/cover.jpg" id="logo3">
                        </div>
                        <form id="acquista_Cover_Olympia" method="POST" action="../php/acquisto_annulla.php?azione=acquista">
                            <input type="text" name="nome_prodotto" value="Cover Smartphone Olympia" hidden>
                            <label class="stile-scritta3">Quantità:</label>
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../php/prodotti.php");

    $sql = "SELECT qta_disponibile FROM prodotto WHERE nome = 'Cover Smartphone Olympia'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
    Ci scusiamo per l'inconveniente...", false, "../php/prodotti.php");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);
    $qta_disponibile = $record["qta_disponibile"];

    echo("<input type='number' class='form-control mb-3' id='Cover_Olympia' name='quantita' min='0' max='" .
        $qta_disponibile . "' step='1'>");
    @pg_free_result($ris);
    @pg_close($conn);
?>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md text-center">
                                        <button class="btn btn-outline-light" type="submit">PROCEDI ALL'ACQUISTO</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!---->
<!--Crea il footer e gestisce l'evento "submit" di ogni modal di prodotto.-->
<script type="text/javascript">
    $(document).ready(function() {
        creaFooter();
        $("#acquista_CX_Pre_Workout").on("submit", function(ev) {
            ev.preventDefault();

            var prodotto = $("#acquista_CX_Pre_Workout input[name=nome_prodotto]").val();
            var versione = $("#acquista_CX_Pre_Workout input[name=versione]:checked").val();
            var quantita = (versione == "25g") ?
                $("#CX_Pre_Workout_25g").val() : $("#CX_Pre_Workout_70g").val();
            
            if (quantita == "" || quantita == "0")
                return false;
            Swal.fire({
                customClass: {
                    title: "titolo_domanda", content: "testo_domanda"
                }, showCancelButton: true, icon: "question", title: "ACQUISTO",
                html: `Sei sicuro di voler procedere con l'acquisto?<br>
                Questo è il prodotto che hai scelto:<br>
                PRODOTTO: ` + prodotto + " " + versione + `<br>
                QUANTITA': ` + quantita,
                confirmButtonText: "Sì", cancelButtonText: "No"
            }).then(function (confermato) {
                if (confermato.value)
                    $("#acquista_CX_Pre_Workout").off("submit").submit();
            });
            return false;
        });
        $("#acquista_CX_BCAA_Capsules").on("submit", function(ev) {
            ev.preventDefault();

            var prodotto = $("#acquista_CX_BCAA_Capsules input[name=nome_prodotto]").val();
            var versione = $("#acquista_CX_BCAA_Capsules input[name=versione]:checked").val();
            var quantita = (versione == "60c") ?
                $("#CX_BCAA_Capsules_60c").val() : $("#CX_BCAA_Capsules_200c").val();
            
            if (quantita == "" || quantita == "0")
                return false;
            Swal.fire({
                customClass: {
                    title: "titolo_domanda", content: "testo_domanda"
                }, showCancelButton: true, icon: "question", title: "ACQUISTO",
                html: `Sei sicuro di voler procedere con l'acquisto?<br>
                Questo è il prodotto che hai scelto:<br>
                PRODOTTO: ` + prodotto + " " + versione + `<br>
                QUANTITA': ` + quantita,
                confirmButtonText: "Sì", cancelButtonText: "No"
            }).then(function (confermato) {
                if (confermato.value)
                    $("#acquista_CX_BCAA_Capsules").off("submit").submit();
            });
            return false;
        });
        $("#acquista_CX_Protein_Powder").on("submit", function(ev) {
            ev.preventDefault();

            var prodotto = $("#acquista_CX_Protein_Powder input[name=nome_prodotto]").val();
            var versione = $("#acquista_CX_Protein_Powder input[name=versione]:checked").val();
            var quantita = (versione == "25g") ?
                $("#CX_Protein_Powder_25g").val() : $("#CX_Protein_Powder_70g").val();
            
            if (quantita == "" || quantita == "0")
                return false;
            Swal.fire({
                customClass: {
                    title: "titolo_domanda", content: "testo_domanda"
                }, showCancelButton: true, icon: "question", title: "ACQUISTO",
                html: `Sei sicuro di voler procedere con l'acquisto?<br>
                Questo è il prodotto che hai scelto:<br>
                PRODOTTO: ` + prodotto + " " + versione + `<br>
                QUANTITA': ` + quantita,
                confirmButtonText: "Sì", cancelButtonText: "No"
            }).then(function (confermato) {
                if (confermato.value)
                    $("#acquista_CX_Protein_Powder").off("submit").submit();
            });
            return false;
        });
        $("#acquista_CX_Protein_Powder2").on("submit", function(ev) {
            ev.preventDefault();

            var prodotto = $("#acquista_CX_Protein_Powder2 input[name=nome_prodotto]").val();
            var versione = $("#acquista_CX_Protein_Powder2 input[name=versione]:checked").val();
            var quantita = (versione == "25g") ?
                $("#CX_Protein_Powder2_25g").val() : $("#CX_Protein_Powder2_70g").val();
            
            if (quantita == "" || quantita == "0")
                return false;
            Swal.fire({
                customClass: {
                    title: "titolo_domanda", content: "testo_domanda"
                }, showCancelButton: true, icon: "question", title: "ACQUISTO",
                html: `Sei sicuro di voler procedere con l'acquisto?<br>
                Questo è il prodotto che hai scelto:<br>
                PRODOTTO: ` + prodotto + " " + versione + `<br>
                QUANTITA': ` + quantita,
                confirmButtonText: "Sì", cancelButtonText: "No"
            }).then(function (confermato) {
                if (confermato.value)
                    $("#acquista_CX_Protein_Powder2").off("submit").submit();
            });
            return false;
        });
        $("#acquista_T-Shirt_Olympia").on("submit", function(ev) {
            ev.preventDefault();

            var prodotto = $("#acquista_T-Shirt_Olympia input[name=nome_prodotto]").val();
            var versione = $("#acquista_T-Shirt_Olympia input[name=versione]:checked").val();
            var quantita;
            
            switch (versione)
            {
            case "XS":
                quantita = $("#T-Shirt_Olympia_XS").val();
                break;
            case "S":
                quantita = $("#T-Shirt_Olympia_S").val();
                break;
            case "M":
                quantita = $("#T-Shirt_Olympia_M").val();
                break;
            case "L":
                quantita = $("#T-Shirt_Olympia_L").val();
                break;
            case "XL":
                quantita = $("#T-Shirt_Olympia_XL").val();
                break;
            }            
            if (quantita == "" || quantita == "0")
                return false;
            Swal.fire({
                customClass: {
                    title: "titolo_domanda", content: "testo_domanda"
                }, showCancelButton: true, icon: "question", title: "ACQUISTO",
                html: `Sei sicuro di voler procedere con l'acquisto?<br>
                Questo è il prodotto che hai scelto:<br>
                PRODOTTO: ` + prodotto + " " + versione + `<br>
                QUANTITA': ` + quantita,
                confirmButtonText: "Sì", cancelButtonText: "No"
            }).then(function (confermato) {
                if (confermato.value)
                    $("#acquista_T-Shirt_Olympia").off("submit").submit();
            });
            return false;
        });
        $("#acquista_Borsa_Olympia").on("submit", function(ev) {
            ev.preventDefault();

            var prodotto = $("#acquista_Borsa_Olympia input[name=nome_prodotto]").val();
            var quantita = $("#Borsa_Olympia").val();
                       
            if (quantita == "" || quantita == "0")
                return false;
            Swal.fire({
                customClass: {
                    title: "titolo_domanda", content: "testo_domanda"
                }, showCancelButton: true, icon: "question", title: "ACQUISTO",
                html: `Sei sicuro di voler procedere con l'acquisto?<br>
                Questo è il prodotto che hai scelto:<br>
                PRODOTTO: ` + prodotto + `<br>
                QUANTITA': ` + quantita,
                confirmButtonText: "Sì", cancelButtonText: "No"
            }).then(function (confermato) {
                if (confermato.value)
                    $("#acquista_Borsa_Olympia").off("submit").submit();
            });
            return false;
        });
        $("#acquista_Cover_Olympia").on("submit", function(ev) {
            ev.preventDefault();

            var prodotto = $("#acquista_Cover_Olympia input[name=nome_prodotto]").val();
            var quantita = $("#Cover_Olympia").val();
                       
            if (quantita == "" || quantita == "0")
                return false;
            Swal.fire({
                customClass: {
                    title: "titolo_domanda", content: "testo_domanda"
                }, showCancelButton: true, icon: "question", title: "ACQUISTO",
                html: `Sei sicuro di voler procedere con l'acquisto?<br>
                Questo è il prodotto che hai scelto:<br>
                PRODOTTO: ` + prodotto + `<br>
                QUANTITA': ` + quantita,
                confirmButtonText: "Sì", cancelButtonText: "No"
            }).then(function (confermato) {
                if (confermato.value)
                    $("#acquista_Cover_Olympia").off("submit").submit();
            });
            return false;
        });
    });          
</script>
<!---->
    </main>
</body>       