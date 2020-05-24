function controllaElemento(elem)
{
    if (elem.val() == "")
        elem.addClass("is-invalid");
    else
        elem.removeClass("is-invalid");
}

function controllaUsername()
{
    controllaElemento($("#username"));
}

function controllaPassword()
{
    controllaElemento($("#password"));
}

function validaForm()
{
    if ($("#username").val() == "")
        return false;
    if ($("#password").val() == "")
        return false;
    return true;
}