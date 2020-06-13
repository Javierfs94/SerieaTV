<?php

if ($_SESSION["perfil"] != "basico" && $_SESSION["perfil"] != "premium") {
    header("Location: index.php");
} else{
    if ($_SESSION["perfil"] == "premium" || $_SESSION["reproduccion"][0]["id_plan"] == 1) {
        echo "<p>Reproduciendo serie</p>";
    } elseif ($_SESSION["perfil"] == "basico" && $_SESSION["reproduccion"][0]["id_plan"] == 2) {
        echo "<p>No tiene el plan necesario para ver esta serie. Pulse el botón para actualizar su plan gratuitamente</p>
        <p>Una vez su plan sea actualizado, tendrá que volver a logearse en la plataforma</p>
        ";

        echo "<form action=".$_SERVER['PHP_SELF']."?page=visualizacionSerie"." method=\"post\">
        <input type='submit' value='Actualice su plan' name='actualizarPlan'>
        </form>";

        if (isset($_POST["actualizarPlan"])) {
            $_SESSION["user"]->actualizarAPremium($_SESSION["idUser"]);
            header("Location: ./includes/logout.php");
        }
    }
}

?>