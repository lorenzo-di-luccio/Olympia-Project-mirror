<!--Chiamata soltanto al primo avvio. Riprende la sessione PHP lasciata aperta dopo l'ultima
chiusura del sito, se c'è. In caso positivo, cancella tutto il contenuto dell'array
associativo $_SESSION e rilascia le risorse della suddetta sessione PHP.-->
<?php
    session_start();
    if (isset($_SESSION["username"]))
    {
        session_unset();
        session_destroy();
    }
?>
<!---->
<!--PAGINA DI TRANSIZIONE-->
<!--Chiamata soltanto al primo avvio e principalmente per pulizia. Cancella tutto il contenuto
del Session Storage della sessione lasciata aperta dopo l'ultima chiusura del sito se c'è,
rimuovendo le celle del corrispondente array associativo. Successivamente ne crea una per non
richiamare questa procedura di reset di sessione durante la navigazione. Infine reindirizza
all'home page.-->
<script type="text/javascript">
    if (typeof sessionStorage["primo"] == "undefined" &&
        typeof sessionStorage["username"] != "undefined")
    {
        sessionStorage.clear();
        sessionStorage["primo"] = "ok";
    }
    window.location.replace("../html/index.html");
</script>
<!---->