/**
 * Filtro. Regola la visibilità delle righe della tabella a seconda della voce selezionata
 * nell'elemento <select></select> corrispondente.
 */
function filtraProdottiAcquisti()
{
    var prodotto = $("#prodotto_acquisti option:selected").val();

    if (prodotto == "*")
        $("#div_tabella_elenco table tbody tr").attr("hidden", false);
    else
        $("#div_tabella_elenco table tbody tr").each(function() {
            if ($(this).children().first().text() == prodotto)
                $(this).attr("hidden", false);
            else
                $(this).attr("hidden", true);
        });
}