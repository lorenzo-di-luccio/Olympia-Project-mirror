function creaNavbar()
{
    var navbar = document.createElement("nav");

    navbar.setAttribute("id", "navbar-olympia");
    navbar.classList.add("navbar");
    navbar.classList.add("navbar-expand-md");
    navbar.classList.add("navbar-dark");
    navbar.classList.add("fixed-top");
    navbar.classList.add("bg-dark");
    navbar.innerHTML = `
    <a class="navbar-brand" href="../html/index.html#HOME_"><img src="../img/logo3.png" id="logo-navbar" alt=""></img></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navs_collapse" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navs_collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown" id="HOME">
                <a class="nav-link dropdown-toggle" href="" id="_HOME" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-home"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="_HOME">
                    <a class="dropdown-item" id="olympia" href="../html/index.html#HOME_">OLYMPIA</a>
                    <a class="dropdown-item" id="corsi" href="../html/index.html#CORSI_">CORSI</a>
                    <a class="dropdown-item" id="orario" href="../html/index.html#ORARIO_">ORARIO</a>
                    <a class="dropdown-item" id="dove-siamo" href="../html/index.html#DOVE_SIAMO">DOVE SIAMO</a>
                </div>
            </li>
            <li class="nav-item" id="CHI-SIAMO">
                <a class="nav-link" href="../html/chi_siamo.html">CHI SIAMO</a>
            </li>
            <li class="nav-item dropdown" id="SHOP">
                <a class="nav-link dropdown-toggle" href="" id="_SHOP" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-shopping-cart"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="_SHOP">
                    <a class="dropdown-item" id="prodotti" href="../php/prodotti.php">PRODOTTI</a>
                    <a class="dropdown-item" id="carrello" href="../php/carrello.php" hidden>CARRELLO</a>
                </div>
            </li>
            <li class="nav-item" id="PRENOTAZIONE" hidden>
                <a class="nav-link" href="../php/prenotazione.php">PRENOTAZIONE</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item" id="GESTIONE" hidden>
                <a class="nav-link" href="../php/gestione.php">
                    <i class="fas fa-cog"></i>
                </a>
            </li>
            <li class="nav-item" id="ISCRIZIONE">
                <a class="nav-link" href="../html/iscrizione.html">
                    <i class="fas fa-user-plus"></i>
                </a>
            </li>
            <li class="nav-item" id="DISISCRIZIONE" hidden>
                <a class="nav-link" href="#" onclick="
                    event.preventDefault(); Swal.fire({
                        customClass: {
                            title: 'titolo_domanda', content: 'testo_domanda'
                        }, showCancelButton: true, icon: 'question', title: 'DISISCRIZIONE',
                        html: 'Sei sicuro di voler procedere disiscrivendoti?',
                        confirmButtonText: 'Sì', cancelButtonText: 'No'
                    }).then(function(confermato) {
                        if (confermato.value)
                            window.location.replace('../php/disiscrizione.php');
                    });">
                    <i class="fas fa-user-minus"></i>
                </a>
            </li>
            <li class="nav-item dropdown" id="UTENTE">
                <a class="nav-link dropdown-toggle" href="" id="_UTENTE" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user"></i><span id="span_username"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="_UTENTE">
                    <a class="dropdown-item" id="login" href="../html/login.html">LOGIN</a>
                    <a class="dropdown-item" id="logout" href="../php/logout.php" hidden>LOGOUT</a>
                    <a class="dropdown-item" id="i_miei_corsi" href="../php/miei_corsi.php" hidden>I MIEI CORSI</a>
                    <a class="dropdown-item" id="il_mio_profilo" href="../php/mio_profilo.php" hidden>IL MIO PROFILO</a>
                </div>
            </li>
        </ul>
    </div>
    `;
    document.body.firstElementChild.appendChild(navbar);
}

function impostaVoci()
{
    if (sessionStorage["loggato"] == "t")
    {
        $("#ISCRIZIONE").attr("hidden", true);
        $("#DISISCRIZIONE").attr("hidden", false);
        $("#span_username").attr("hidden", false).html(" @" + sessionStorage["username"]);
        $("#login").attr("hidden", true);
        $("#logout").attr("hidden", false);
        $("#i_miei_corsi").attr("hidden", false);
        $("#il_mio_profilo").attr("hidden", false);
    }
    else
    {
        $("#ISCRIZIONE").attr("hidden", false);
        $("#DISISCRIZIONE").attr("hidden", true);
        $("#span_username").attr("hidden", true).html("");
        $("#login").attr("hidden", false);
        $("#logout").attr("hidden", true);
        $("#i_miei_corsi").attr("hidden", true);
        $("#il_mio_profilo").attr("hidden", true);
    }
    if (sessionStorage["ruolo"] == "admin")
    {
        $("#carrello").attr("hidden", true);
        $("#PRENOTAZIONE").attr("hidden", true);
        $("#GESTIONE").attr("hidden", false);
        $("#_UTENTE i").removeClass("fa-user").addClass("fa-user-cog");
        $("#i_miei_corsi").attr("hidden", true);
    }
    else if (sessionStorage["ruolo"] == "socio")
    {
        $("#carrello").attr("hidden", false);
        $("#PRENOTAZIONE").attr("hidden", false);
        $("#GESTIONE").attr("hidden", true);
        $("#_UTENTE i").removeClass("fa-user-cog").addClass("fa-user");
        $("#i_miei_corsi").attr("hidden", false);
    }
}

function azionaVocePrincipale(voce)
{
    $("#" + voce).addClass("active");
}