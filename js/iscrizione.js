function controllaElemento(elem)
{
    if (elem.val() == "")
        elem.addClass("is-invalid");
    else
        elem.removeClass("is-invalid");
}

function controllaNome()
{
    controllaElemento($("#nome"));
}

function controllaCognome()
{
    controllaElemento($("#cognome"));
}

function controllaDataDiNascita()
{
    controllaElemento($("#data_nascita"));
}

function controllaEmail()
{
    controllaElemento($("#email"));
}

function controllaUsername()
{
    controllaElemento($("#username"));
}

function controllaPassword()
{
    var inputPassword = $("#password");
    var inputConfermaPassword = $("#conferma_password");
    controllaElemento(inputPassword);
    if (inputPassword.val() == inputConfermaPassword.val())
        inputConfermaPassword.removeClass("is-invalid");
    else
        inputConfermaPassword.addClass("is-invalid");
}

function validaForm()
{
    if ($("#nome").val() == "")
        return false;
    if ($("#cognome").val() == "")
        return false;
    if ($("#data_nascita").val() == "")
        return false;
    if ($("#email").val() == "")
        return false;
    if ($("#username").val() == "")
        return false;
    
    var password = $("#password").val();
    var confermaPassword = $("#conferma_password").val();

    if (password == "")
        return false;
    if (password != confermaPassword)
        return false;
    return true;
}