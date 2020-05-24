function filtraSoci(sezione)
{
    var socio = $("#socio_" + sezione + " option:selected").val();

    if (socio == "*")
        $("#div_" + sezione + " table tbody tr").attr("hidden", false);
    else
        $("#div_" + sezione + " table tbody tr").each(function() {
            if ($(this).children().first().text() == socio)
                $(this).attr("hidden", false);
            else
                $(this).attr("hidden", true);
        });
}

function filtraSociApprovazioni()
{
    filtraSoci("approvazioni");
}

function filtraSociVendite()
{
    filtraSoci("vendite");
}

function filtraSociAbbonamenti()
{
    var socio = $("#socio_abbonamenti option:selected").val();

    if (socio == "*")
    {
        $("#div_cambio_abbonamenti table tbody tr td input").attr("name", "?");
        $("#div_cambio_abbonamenti table tbody tr td select").attr("name", "?");
    }
    else
    {
        $("#div_cambio_abbonamenti table tbody tr").each(function() {
            if ($(this).children().first().children().first().val() == socio)
            {
                $(this).children().first().children().first().attr("name", "socio");
                $(this).children().first().next().children().first().
                    attr("name", "abbonamento");
                $(this).children().first().next().next().children().first().
                    attr("name", "data_scadenza");
            }
            else
            {
                $(this).children().first().children().first().attr("name", "?");
                $(this).children().first().next().children().first().
                    attr("name", "?");
                $(this).children().first().next().next().children().first().
                    attr("name", "?");
            }
        });
    }
}

function filtraProdottiAggiornamento()
{
    var prodotto = $("#aggiornamento_prodotti option:selected").val();

    if (prodotto == "*")
        $("#div_aggiornamento_prodotti table tbody tr").attr("hidden", false);
    else
        $("#div_aggiornamento_prodotti table tbody tr").each(function() {
            if ($(this).children().first().text() == prodotto)
                $(this).attr("hidden", false);
            else
                $(this).attr("hidden", true);
        });
}