function azionaResetSessione()
{
    if (typeof sessionStorage["primo"] == "undefined")
        window.location.replace("../php/reset_sessione.php");
}