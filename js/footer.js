function creaFooter()
{
    var footer = document.createElement("footer");

    footer.setAttribute("id", "footer-olympia");
    footer.classList.add("fixed-bottom");
    footer.classList.add("blog-footer");
    footer.innerHTML = `
    <div class="container-fluid">
        <div class="row">
            <div class="col-md text-center">
                Questo progetto è stato realizzato per il corso di "Linguaggi e Tecnologie per il Web"\t
                <a class="link-footer" href="https://www.dis.uniroma1.it/rosati/lw/">Sito corso</a><br>
                <a class="link-footer" href="#">Torna su</a>
            </div>
        </div>
    </div>
    `;
    document.body.lastElementChild.appendChild(footer);
}