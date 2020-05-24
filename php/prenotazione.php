<?php
    session_start();
    include "connessione_db.php"
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olympia | Prenotazione</title>
    <link type="text/css" rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="../vendor/fontawesome/css/all.min.css">
    <link type="text/css" rel="stylesheet" href="../css/navbar.css">
    <link type="text/css" rel="stylesheet" href="../css/footer.css">
    <link type="text/css" rel="stylesheet" href="../css/prenotazione.css">
    <link type="text/css" rel="stylesheet" href="../css/swal.css">
    <script type="text/javascript" src="../vendor/jquery/jquery-3.4.1.slim.min.js"></script>
    <script type="text/javascript" src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../vendor/fontawesome/js/all.min.js"></script>
    <script type="text/javascript" src="../vendor/sweetalert2/sweetalert2.min.js"></script>
    <script type="text/javascript" src="../js/navbar.js"></script>
    <script type="text/javascript" src="../js/footer.js"></script>
</head>

<body onload="creaNavbar(); impostaVoci(); azionaVocePrincipale('PRENOTAZIONE');">
    <header></header>

    <main>
<?php
    if (! isset($_SESSION["loggato"]) || ! $_SESSION["loggato"])
    {
        echo("
        <h1 class='text-center'>PRENOTAZIONE</h1>
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
        <h1 class='text-center'>PRENOTAZIONE</h1>
        <p style='padding-bottom: 100%'></p>
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_errore', content: 'testo_errore',
        }, icon: 'error', title: 'SEI UN AMMINISTRATORE...', html: 'Non hai bisogno di prenotarti a nessun corso.'
    }).then(function() {
        window.location.replace('../html/index.html');
    });
</script>");
        exit(1);
    }
?>
        <h1 class="text-center">PRENOTAZIONE</h1>
        <div class="container table-responsive">
               <table class="table table-bordless table-dark table-striped">
                   <thead class="thead-dark">
                       <tr>
                           <th class="header" scope="col">Orari</th>
                           <th class="header" scope="col">Lunedì</th>
                           <th class="header" scope="col">Martedì</th>
                           <th class="header" scope="col">Mercoledì</th>
                           <th class="header" scope="col">Giovedì</th>
                           <th class="header" scope="col">Venerdì</th>
                           <th class="header" scope="col">Sabato</th>
                       </tr>
                   </thead>
                   <tbody id="tbody-dark">
                       <tr>
                           <th class="riga-dispari" scope="col">09:00 - 10:30</th>
                           <th class="riga-dispari" scope="col" data-toggle="modal" data-target="#pesistica1LUN"><button class="btn btn-outline-danger bottone1">Pesistica</button></th>
                           <th class="riga-dispari" scope="col" data-toggle="modal" data-target="#pesistica1MAR"><button class="btn btn-outline-danger bottone1">Pesistica</button></th>
                           <th class="riga-dispari" scope="col" data-toggle="modal" data-target="#pesistica1MER"><button class="btn btn-outline-danger bottone1">Pesistica</button></th>
                           <th class="riga-dispari" scope="col" data-toggle="modal" data-target="#pesistica1GIO"><button class="btn btn-outline-danger bottone1">Pesistica</button></th>
                           <th class="riga-dispari" scope="col" data-toggle="modal" data-target="#pesistica1VEN"><button class="btn btn-outline-danger bottone1">Pesistica</button></th>
                           <th class="riga-dispari" scope="col" data-toggle="modal" data-target="#pesistica1SAB"><button class="btn btn-outline-danger bottone1">Pesistica</button></th>
                       </tr>
                       <tr>
                           <th class="riga-pari" scope="col">10:30 - 11:30</th>
                           <th class="riga-pari" scope="col" data-toggle="modal" data-target="#pesistica2LUN"><button class="btn btn-outline-danger bottone2">Pesistica</button></th>
                           <th class="riga-pari" scope="col" data-toggle="modal" data-target="#pesistica2MAR"><button class="btn btn-outline-danger bottone2">Pesistica</button></th>
                           <th class="riga-pari" scope="col" data-toggle="modal" data-target="#pesistica2MER"><button class="btn btn-outline-danger bottone2">Pesistica</button></th>
                           <th class="riga-pari" scope="col" data-toggle="modal" data-target="#pesistica2GIO"><button class="btn btn-outline-danger bottone2">Pesistica</button></th>
                           <th class="riga-pari" scope="col" data-toggle="modal" data-target="#pesistica2VEN"><button class="btn btn-outline-danger bottone2">Pesistica</button></th>
                           <th class="riga-pari" scope="col" data-toggle="modal" data-target="#pesistica2SAB"><button class="btn btn-outline-danger bottone2">Pesistica</button></th>
                       </tr>
                       <tr>
                           <th class="riga-dispari" scope="col">11:30 - 16:30</th>
                           <th class="riga-dispari" scope="col" data-toggle="modal" data-target="#bodybuildingLUN"><button class="btn btn-outline-danger bottone1">Bodybuilding</button></th>
                           <th class="riga-dispari" scope="col" data-toggle="modal" data-target="#bodybuildingMAR"><button class="btn btn-outline-danger bottone1">Bodybuilding</button></th>
                           <th class="riga-dispari" scope="col" data-toggle="modal" data-target="#bodybuildingMER"><button class="btn btn-outline-danger bottone1">Bodybuilding</button></th>
                           <th class="riga-dispari" scope="col" data-toggle="modal" data-target="#bodybuildingGIO"><button class="btn btn-outline-danger bottone1">Bodybuilding</button></th>
                           <th class="riga-dispari" scope="col" data-toggle="modal" data-target="#bodybuildingVEN"><button class="btn btn-outline-danger bottone1">Bodybuilding</button></th>
                           <th class="riga-dispari" scope="col" data-toggle="modal" data-target="#bodybuildingSAB"><button class="btn btn-outline-danger bottone1">Bodybuilding</button></th>
                       </tr>
                       <tr>
                           <th class="riga-pari" scope="col">16:30 - 18:30</th>
                           <th class="riga-pari" scope="col" data-toggle="modal" data-target="#crossfit1LUN"><button class="btn btn-outline-danger bottone2">Crossfit C1</button></th>
                           <th class="riga-pari" scope="col" data-toggle="modal" data-target="#crossfit1MAR"><button class="btn btn-outline-danger bottone2">Crossfit C1</button></th>
                           <th class="riga-pari" scope="col" data-toggle="modal" data-target="#crossfit1MER"><button class="btn btn-outline-danger bottone2">Crossfit C1</button></th>
                           <th class="riga-pari" scope="col" data-toggle="modal" data-target="#crossfit1GIO"><button class="btn btn-outline-danger bottone2">Crossfit C1</button></th>
                           <th class="riga-pari" scope="col" data-toggle="modal" data-target="#crossfit1VEN"><button class="btn btn-outline-danger bottone2">Crossfit C1</button></th>
                           <th class="riga-pari" scope="col" data-toggle="modal" data-target="#crossfit1SAB"><button class="btn btn-outline-danger bottone2">Crossfit C1</button></th>
                       </tr>
                       <tr>
                           <th class="riga-dispari" scope="col">18:30 - 19:30</th>
                           <th class="riga-dispari" scope="col" data-toggle="modal" data-target="#crossfit2LUN"><button class="btn btn-outline-danger bottone1">Crossfit C2</button></th>
                           <th class="riga-dispari" scope="col" data-toggle="modal" data-target="#crossfit2MAR"><button class="btn btn-outline-danger bottone1">Crossfit C2</button></th>
                           <th class="riga-dispari" scope="col" data-toggle="modal" data-target="#crossfit2MER"><button class="btn btn-outline-danger bottone1">Crossfit C2</button></th>
                           <th class="riga-dispari" scope="col" data-toggle="modal" data-target="#crossfit2GIO"><button class="btn btn-outline-danger bottone1">Crossfit C2</button></th>
                           <th class="riga-dispari" scope="col" data-toggle="modal" data-target="#crossfit2VEN"><button class="btn btn-outline-danger bottone1">Crossfit C2</button></th>
                           <th class="riga-dispari" scope="col" data-toggle="modal" data-target="#crossfit2SAB"><button class="btn btn-outline-danger bottone1">Crossfit C2</button></th>
                       </tr>
                       <tr>
                           <th class="riga-pari" scope="col">19:30 - 20:30</th>
                           <th class="riga-pari" scope="col" data-toggle="modal" data-target="#crossfit3LUN"><button class="btn btn-outline-danger bottone2">Crossfit C3</button></th>
                           <th class="riga-pari" scope="col" data-toggle="modal" data-target="#crossfit3MAR"><button class="btn btn-outline-danger bottone2">Crossfit C3</button></th>
                           <th class="riga-pari" scope="col" data-toggle="modal" data-target="#crossfit3MER"><button class="btn btn-outline-danger bottone2">Crossfit C3</button></th>
                           <th class="riga-pari" scope="col" data-toggle="modal" data-target="#crossfit3GIO"><button class="btn btn-outline-danger bottone2">Crossfit C3</button></th>
                           <th class="riga-pari" scope="col" data-toggle="modal" data-target="#crossfit3VEN"><button class="btn btn-outline-danger bottone2">Crossfit C3</button></th>
                           <th class="riga-pari" scope="col" data-toggle="modal" data-target="#crossfit1SAB"><button class="btn btn-outline-danger bottone2">Crossfit C3</button></th>
                       </tr>
                   </tbody>
               </table>
           </div>

<!------------------------------------------------------
                     CROSSFIT1-LUN
------------------------------------------------------->
            <div class="modal fade" id="crossfit1LUN" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Crossfit - Classe 1 - LUN" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Crossfit - Classe 1 - LUN'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     CROSSFIT1-MAR
------------------------------------------------------->
<div class="modal fade" id="crossfit1MAR" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Crossfit - Classe 1 - MAR" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Crossfit - Classe 1 - MAR'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     CROSSFIT1-MER 
------------------------------------------------------->
<div class="modal fade" id="crossfit1MER" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Crossfit - Classe 1 - MER" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Crossfit - Classe 1 - MER'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     CROSSFIT1-GIO 
------------------------------------------------------->
<div class="modal fade" id="crossfit1GIO" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Crossfit - Classe 1 - GIO" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Crossfit - Classe 1 - GIO'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     CROSSFIT1-VEN 
------------------------------------------------------->
<div class="modal fade" id="crossfit1VEN" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Crossfit - Classe 1 - VEN" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Crossfit - Classe 1 - VEN'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     CROSSFIT1-SAB 
------------------------------------------------------->
<div class="modal fade" id="crossfit1SAB" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Crossfit - Classe 1 - SAB" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Crossfit - Classe 1 - SAB'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     CROSSFIT2-LUN 
------------------------------------------------------->
<div class="modal fade" id="crossfit2LUN" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Crossfit - Classe 2 - LUN" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Crossfit - Classe 2 - LUN'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


<!------------------------------------------------------
                     CROSSFIT2-MAR 
------------------------------------------------------->
<div class="modal fade" id="crossfit2MAR" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Crossfit - Classe 2 - MAR" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Crossfit - Classe 2 - MAR'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


<!------------------------------------------------------
                     CROSSFIT2-MER 
------------------------------------------------------->
<div class="modal fade" id="crossfit2MER" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Crossfit - Classe 2 - MER" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Crossfit - Classe 2 - MER'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        

<!------------------------------------------------------
                     CROSSFIT2-LUN 
------------------------------------------------------->
<div class="modal fade" id="crossfit2GIO" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Crossfit - Classe 2 - GIO" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Crossfit - Classe 2 - GIO'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


<!------------------------------------------------------
                     CROSSFIT2-VEN 
------------------------------------------------------->
<div class="modal fade" id="crossfit2VEN" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Crossfit - Classe 2 - VEN" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Crossfit - Classe 2 - VEN'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


<!------------------------------------------------------
                     CROSSFIT2-SAB 
------------------------------------------------------->
<div class="modal fade" id="crossfit2SAB" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Crossfit - Classe 2 - SAB" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Crossfit - Classe 2 - SAB'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


<!------------------------------------------------------
                     CROSSFIT3-LUN 
------------------------------------------------------->
<div class="modal fade" id="crossfit3LUN" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Crossfit - Classe 3 - LUN" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Crossfit - Classe 3 - LUN'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     CROSSFIT3-MAR 
------------------------------------------------------->
<div class="modal fade" id="crossfit3MAR" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Crossfit - Classe 3 - MAR" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Crossfit - Classe 3 - MAR'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     CROSSFIT3-MER 
------------------------------------------------------->
<div class="modal fade" id="crossfit3MER" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Crossfit - Classe 3 - MER" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Crossfit - Classe 3 - MER'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     CROSSFIT3-GIO 
------------------------------------------------------->
<div class="modal fade" id="crossfit3GIO" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Crossfit - Classe 3 - GIO" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Crossfit - Classe 3 - GIO'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        
<!------------------------------------------------------
                     CROSSFIT3-VEN 
------------------------------------------------------->
<div class="modal fade" id="crossfit3VEN" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Crossfit - Classe 3 - VEN" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Crossfit - Classe 3 - VEN'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     CROSSFIT3-SAB 
------------------------------------------------------->
<div class="modal fade" id="crossfit3SAB" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Crossfit - Classe 3 - SAB" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Crossfit - Classe 3 - SAB'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
                         
<!------------------------------------------------------
                     PESISTICA1-LUN 
------------------------------------------------------->
<div class="modal fade" id="pesistica1LUN" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Pesistica 1 - LUN" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Pesistica 1 - LUN'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     PESISTICA1-MAR 
------------------------------------------------------->
<div class="modal fade" id="pesistica1MAR" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Pesistica 1 - MAR" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Pesistica 1 - MAR'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     PESISTICA1-MER 
------------------------------------------------------->
<div class="modal fade" id="pesistica1MER" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Pesistica 1 - MER" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Pesistica 1 - MER'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     PESISTICA1-GIO 
------------------------------------------------------->
<div class="modal fade" id="pesistica1GIO" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Pesistica 1 - GIO" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Pesistica 1 - GIO'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     PESISTICA1-VEN 
------------------------------------------------------->
<div class="modal fade" id="pesistica1VEN" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Pesistica 1 - VEN" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Pesistica 1 - VEN'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     PESISTICA1-SAB 
------------------------------------------------------->
<div class="modal fade" id="pesistica1SAB" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Pesistica 1 - SAB" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Pesistica 1 - SAB'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     PESISTICA2-LUN 
------------------------------------------------------->
<div class="modal fade" id="pesistica2LUN" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Pesistica 2 - LUN" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Pesistica 2 - LUN'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     PESISTICA2-MAR 
------------------------------------------------------->
<div class="modal fade" id="pesistica2MAR" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Pesistica 2 - MAR" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Pesistica 2 - MAR'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     PESISTICA2-MER 
------------------------------------------------------->
<div class="modal fade" id="pesistica2MER" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Pesistica 2 - MER" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Pesistica 2 - MER'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     PESISTICA2-GIO 
------------------------------------------------------->
<div class="modal fade" id="pesistica2GIO" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Pesistica 2 - GIO" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Pesistica 2 - GIO'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     PESISTICA2-VEN 
------------------------------------------------------->
<div class="modal fade" id="pesistica2VEN" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Pesistica 2 - VEN" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Pesistica 2 - VEN'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     PESISTICA2-SAB 
------------------------------------------------------->
<div class="modal fade" id="pesistica2SAB" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Pesistica 2 - SAB" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Pesistica 2 - SAB'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     BODYBUILDING-LUN 
------------------------------------------------------->
<div class="modal fade" id="bodybuildingLUN" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Bodybuilding - LUN" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Bodybuilding - LUN'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     BODYBUILDING-MAR 
------------------------------------------------------->
<div class="modal fade" id="bodybuildingMAR" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Bodybuilding - MAR" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Bodybuilding - MAR'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     BODYBUILDING-MER 
------------------------------------------------------->
<div class="modal fade" id="bodybuildingMER" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Bodybuilding - MER" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Bodybuilding - MER'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     BODYBUILDING-GIO 
------------------------------------------------------->
<div class="modal fade" id="bodybuildingGIO" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Bodybuilding - GIO" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Bodybuilding - GIO'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     BODYBUILDING-VEN 
------------------------------------------------------->
<div class="modal fade" id="bodybuildingVEN" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Bodybuilding - VEN" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Bodybuilding - VEN'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<!------------------------------------------------------
                     BODYBUILDING-SAB 
------------------------------------------------------->
<div class="modal fade" id="bodybuildingSAB" style="top:30%; " >
                <div class="modal-dialog">
                    <div class="modal-content" style=" background: #050505;">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="stile-scritta3 ">
                                PRENOTA ORA LA TUA LEZIONE&nbsp;
                            </h4>
                            <form id="" name="acquista" method="POST" action="../php/op_prenotazione.php">
                                <input type="text" name="corso" value="Bodybuilding - SAB" hidden>
                               <div class="tasto">
                                   <input class="" type="submit" value="PRENOTA">
                               </div> 
                                

                                <p>posti disponibili:
<?php
    $conn = @pg_connect(stringaConnessioneDB());

    controllaConnessione($conn, "../html/index.html");

    $sql = "SELECT num_posti_rimasti from corso where nome = 'Bodybuilding - SAB'";
    $ris = @pg_query($conn, $sql);

    controllaRisultato($conn, $ris, "Si è verificato un errore interno nel database!\n
        Ci scusiamo per l'inconveniente...", false, "../html/index.html");

    $record = @pg_fetch_array($ris, 0, PGSQL_ASSOC);

    echo($record["num_posti_rimasti"]);
    @pg_free_result($ris);
    @pg_close($conn);
?>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
<script type="text/javascript">
    $(document).ready(function() {
        creaFooter();
        $("h4").addClass("text-center");
        $(".tasto").addClass("text-center");
        $("p").css("color", "blue").css("font-weight", "700");
        $("input[value=PRENOTA]").addClass("btn btn-outline-light btn-lg bottone-modal");
    });
</script>
    </main>
</body>
</html>