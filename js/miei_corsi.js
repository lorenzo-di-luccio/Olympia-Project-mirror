function filtraMieiCorsi()
{
    var corso = $("#miei_corsi option:selected").val();

    if (corso == "*")
        $("#tabella_miei_corsi table tbody tr").attr("hidden", false);
    else
        $("#tabella_miei_corsi table tbody tr").each(function() {
            if ($(this).children().first().text() == corso)
                $(this).attr("hidden", false);
            else
                $(this).attr("hidden", true);
        });
}