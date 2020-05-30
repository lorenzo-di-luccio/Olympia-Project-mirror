<?php
    /**
     * Funzione di utilità. Costruisce la stringa per permettere la connessione al database.
     * @returns la stringa per la connessione al database appena construita.
     */
    function stringaConnessioneDB()
    {
        return "host=localhost dbname=olympia user=postgres password=R0o7P0stgre5L@R!";
    }

    /**
     * Funzione di utilità. Controlla lo stato della connessione con il database. Se quest'ultima
     * è attiva, fa procedere l'esecuzione, altrimenti visualizza un alert con il corrispondente
     * messaggio di errore che, appena chiuso, riporta alla pagina nella locazione passata come
     * parametro.
     * @param conn: riferimento alla connessione instaurata con il database.
     * @param locazione: stringa con la URL alla pagina di reindirizzamento in caso di errore.
     */
    function controllaConnessione(&$conn, $locazione)
    {
        if (! $conn)
        {
            echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_errore', content: 'testo_errore',
        }, icon: 'error', title: 'ERRORE...', html: 'Connessione al DB fallita!',
    }).then(function() {
        window.location.replace('" . $locazione . "');
    });
</script>");
            exit(1);
        }
    }

    /**
     * Funzione di utilità. Controlla il risultato fornito dall'esecuzione di un comando SQL sul
     * database passato come parametro. Se è consistente, fa procedere l'esecuzione, altrimenti
     * effettua il ROLLBACK sul database se specificato, libera le risorse associate al database
     * e visualizza un alert con il messaggio di errore passato come parametro che, appena
     * chiuso, riporta alla pagina nella locazione passata come parametro.
     * @param conn: riferimento alla connessione instaurata con il database.
     * @param ris: riferimento al risultato fornito dall'esecuzione di un comando SQL sul
     * database.
     * @param errore: stringa con il messaggio di errore che l'alert stamperà.
     * @param rollback: booleano che specifica se effettuare il ROLLBACK o no.
     * @param locazione: stringa con la URL alla pagina di reindirizzamento in caso di errore.
     */
    function controllaRisultato(&$conn, &$ris, $errore, $rollback, $locazione)
    {
        if (! $ris)
        {
            @pg_free_result($ris);
            if ($rollback)
            {
                @pg_query($conn, "ROLLBACK");
                @pg_free_result($ris);
            }
            @pg_close($conn);
            echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_errore', content: 'testo_errore',
        }, icon: 'error', title: 'ERRORE...', html: `" . $errore . "`,
    }).then(function() {
        window.location.replace(`" . $locazione . "`);
    });
</script>");
            exit(1);
        }
    }

    /**
     * Funzione di utilità. Controlla il record di una tabella del database passato come
     * parametro. Se non è vuoto, fa procedere l'esecuzione, altrimenti libera le risorse
     * associate al database e visualizza un alert con il messaggio di errore passato come
     * parametro che, appena chiuso, riporta alla pagina nella locazione passata come parametro.
     * @param conn: riferimento alla connessione instaurata con il database.
     * @param ris: riferimento al risultato fornito dall'esecuzione di un comando SQL sul
     * database.
     * @param record: riferimento al record di una tabella del database.
     * @param errore: stringa con il messaggio di errore che l'alert stamperà.
     * @param locazione: stringa con la URL alla pagina di reindirizzamento in caso di errore.
     */
    function controllaRecord(&$conn, &$ris, &$record, $errore, $locazione)
    {
        if (! $record)
        {
            @pg_free_result($ris);
            @pg_close($conn);
            echo("
<script type='text/javascript'>
    Swal.fire({
        customClass: {
            title: 'titolo_errore', content: 'testo_errore',
        }, icon: 'error', title: 'ERRORE...', html: `" . $errore . "`,
    }).then(function() {
        window.location.replace(`" . $locazione . "`);
    });
</script>");
            exit(1);
        }
    }
?>