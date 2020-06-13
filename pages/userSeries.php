<?php

if ($_SESSION["perfil"] != "basico" && $_SESSION["perfil"] != "premium") {
  header("Location: index.php");
} else {

    echo "<form action=".$_SERVER['PHP_SELF']."?page=userSeries"." method=\"post\">
    Serie: <input type='text' name='busqueda'> Buscar
    <input type='submit' value='Buscar' name='buscar'>
    </form>";
    
    if (isset($_POST['buscar'])){
      echo "<h2>Series encontradas</h2>";
      imprimeSeries($_SESSION["serie"]->buscarSeries($_POST["busqueda"]));
    } else {
      echo "<p>Listado de Series</p>";
      imprimeSeries($_SESSION["serie"]->mostrarSeriesOrdenadas());
    }

  if (isset($_GET["verSerie"])) {
    $_SESSION["serie"]->aumentarReproduccion($_GET["verSerie"]);
    $_SESSION["reproduccion"] = $_SESSION["serie"]->getSerieById($_GET["verSerie"]); 
    header("Location: index.php?page=visualizacionSerie");
  }
}

?>