/**
 * Controlla lo stato di un elemento della form passato come parametro. A seconda dello stato,
 * aggiunge o rimuove una classe CSS con conseguente effetto grafico.
 * @param elem: elemento HTML di cui controllare lo stato, passato usando JQuery.
 */
function controllaElemento(elem)
{
    if (elem.val() == "")
        elem.addClass("is-invalid");
    else
        elem.removeClass("is-invalid");
}

/**
 * Funzione di utilità. Controlla lo stato del nome.
 */
function controllaNome()
{
    controllaElemento($("#nome"));
}

/**
 * Funzione di utilità. Controlla lo stato del cognome.
 */
function controllaCognome()
{
    controllaElemento($("#cognome"));
}

/**
 * Funzione di utilità. Controlla lo stato della data di nascita.
 */
function controllaDataDiNascita()
{
    controllaElemento($("#data_nascita"));
}

/**
 * Funzione di utilità. Controlla lo stato dell'email.
 */
function controllaEmail()
{
    controllaElemento($("#email"));
}

/**
 * Funzione di utilità. Controlla lo stato dell'username.
 */
function controllaUsername()
{
    controllaElemento($("#username"));
}

/**
 * Funzione di utilità. Controlla lo stato della password e della sua conferma.
 */
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

/**
 * Controlla se tutti i campi della form sono stati compilati correttamente.
 * @returns true se i campi sono stati compilati correttamente, permettendo di inviare i dati
 * inseriti, false altrimenti, bloccando la suddetta operazione di invio.
 */
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