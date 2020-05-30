/**
 * Filtro. Regola la visibilità delle righe di una tabella in una sezione passata come argomento
 * a seconda della voce selezionata nell'elemento <select></select> corrispondente.
 * @param sezione: stringa con l'id della sezione in cui si trova la tabella.
 */
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

/**
 * Funzione di utilità. Regola la visibilità delle righe della tabella nella sezione
 * "approvazioni" a seconda della voce selezionata nell'elemento <select></select>
 * corrispondente.
 */
function filtraSociApprovazioni()
{
    filtraSoci("approvazioni");
}

/**
 * Funzione di utilità. Regola la visibilità delle righe della tabella nella sezione "vendite" a
 * seconda della voce selezionata nell'elemento <select></select> corrispondente.
 */
function filtraSociVendite()
{
    filtraSoci("vendite");
}

/**
 * Filtro. Regola la visibilità delle righe della tabella nella sezione "cambio abbonamenti" e
 * anche i vari attributi 'name' per inviare i dati giusti a seconda della voce selezionata
 * nell'elemento <select></select> corrispondente.
 */
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

/**
 * Filtro. Regola la visibilità delle righe della tabella nella sezione "aggiornamento prodotti"
 * a seconda della voce selezionata nell'elemento <select></select> corrispondente.
 */
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