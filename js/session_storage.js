/**
 * Scrive sul Session Storage i dati di un utente loggato passati come parametri creando le
 * opportune celle dell'array associativo corrispondente.
 * @param loggato: stringa che può assumere i valori "t" o "f"; è "t" se c'è un utente loggato,
 * altrimenti è "f".
 * @param username: stringa con l'username dell'utente loggato.
 * @param approvato: stringa che può assumere i valori "t" o "f"; è "t" se l'utente è stato
 * approvato da un amministratore, altrimenti è "f".
 * @param ruolo: stringa che può assumere i valori "", "socio" o "admin"; è "" se non c'è un
 * utente loggato al momento, è "socio" se l'utente loggato è un socio, altrimenti è "admin" se
 * l'utente loggato è un amministratore.
 * @param caricato: stringa che può assumere i valori "t" o "f"; è "t" se il Session Storage è
 * stato caricato con dei nuovi valori, altrimento è "f".
 */
function impostaSessionStorage(loggato, username, approvato, ruolo, caricato)
{
    sessionStorage["loggato"] = loggato;
    sessionStorage["username"] = username;
    sessionStorage["approvato"] = approvato;
    sessionStorage["ruolo"] = ruolo;
    sessionStorage["caricato"] = caricato;
}

/**
 * Funzione di utilità. Ripristina il Session Storage ad uno stato coerente non caricato con
 * alcun utente loggato.
 */
function ripristinaSessionStorage()
{
    impostaSessionStorage("f", "", "f", "", "f");
    sessionStorage.removeItem("caricato");
}

/**
 * Funzione di utilità. Imposta il Session Storage ad uno stato coerente caricato con alcun
 * utente loggato.
 */
function caricaSessionStorage()
{
    if (typeof sessionStorage["caricato"] == "undefined" || sessionStorage["caricato"] == "f")
        impostaSessionStorage("f", "", "f", "", "t");
}