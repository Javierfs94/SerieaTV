<?php

if ($_SESSION["perfil"] != "basico" && $_SESSION["perfil"] != "premium") {
  header("Location: index.php");
} else {

    $carta = new Carta($_SESSION["usuario"]);
    $carta->escribirCartaPago();

    echo "<p><a href=\"./archivos/cartapago".$_SESSION["usuario"].".txt\" download=\"cartapago".$_SESSION["usuario"].".txt\">Descargar la carta de ".$_SESSION["usuario"]."</a></p>";
  
  
}

?>