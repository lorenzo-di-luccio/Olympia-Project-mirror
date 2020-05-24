<?php
    session_start();
    if (isset($_SESSION["username"]))
    {
        session_unset();
        session_destroy();
    }
?>
<script type="text/javascript">
    if (typeof sessionStorage["primo"] == "undefined" &&
        typeof sessionStorage["username"] != "undefined")
    {
        sessionStorage.clear();
        sessionStorage["primo"] = "ok";
    }
    window.location.replace("../html/index.html");
</script>