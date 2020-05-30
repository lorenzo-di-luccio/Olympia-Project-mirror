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
 * Funzione di utilità. Controlla lo stato dell'username.
 */
function controllaUsername()
{
    controllaElemento($("#username"));
}

/**
 * Funzione di utilità. Controlla lo stato della password.
 */
function controllaPassword()
{
    controllaElemento($("#password"));
}

/**
 * Controlla se tutti i campi della form sono stati compilati correttamente.
 * @returns true se i campi sono stati compilati correttamente, permettendo di inviare i dati
 * inseriti, false altrimenti, bloccando la suddetta operazione di invio.
 */
function validaForm()
{
    if ($("#username").val() == "")
        return false;
    if ($("#password").val() == "")
        return false;
    return true;
}