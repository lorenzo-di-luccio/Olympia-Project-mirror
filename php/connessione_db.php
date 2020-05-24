<?php
    function stringaConnessioneDB()
    {
        return "host=localhost dbname=olympia user=postgres password=R0o7P0stgre5L@R!";
    }

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