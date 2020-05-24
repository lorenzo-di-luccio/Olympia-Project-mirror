function impostaSessionStorage(loggato, username, approvato, ruolo, caricato)
{
    sessionStorage["loggato"] = loggato;
    sessionStorage["username"] = username;
    sessionStorage["approvato"] = approvato;
    sessionStorage["ruolo"] = ruolo;
    sessionStorage["caricato"] = caricato;
}

function ripristinaSessionStorage()
{
    impostaSessionStorage("f", "", "f", "", "f");
    sessionStorage["caricato"] = "undefined";
}

function caricaSessionStorage()
{
    if (typeof sessionStorage["caricato"] == "undefined" || sessionStorage["caricato"] == "f")
        impostaSessionStorage("f", "", "f", "", "t");
}