/**
 * Chiamata soltanto al primo avvio. Aziona il reset di una sessione lasciata aperta dopo
 * dopo l'ultima chiusura del sito, se c'è. In caso positivo reindirizza alla corrispondente
 * pagina PHP.
 */
function azionaResetSessione()
{
    if (typeof sessionStorage["primo"] == "undefined")
        window.location.replace("../php/reset_sessione.php");
}