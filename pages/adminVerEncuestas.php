<?php

if ($_SESSION["perfil"] != "admin") {
  header("Location: index.php");
}else {

  echo "<h1>Encuestas terminadas encuesta</h1>";
  $encuestas = Encuesta::singleton();
  
  echo "<table>
  <tr>
  <th>Titulo</th>
  <th>Fecha Hora Inicio</th>
  <th>Fecha Hora Final</th>
  <th>Media</th>
  </tr>
  ";
  $array = $encuestas->getEncuestasTerminadas();

    foreach ($array as $encuesta) {
        echo "<tr>
        <td>".$encuesta["Titulo"]."</td>
        <td>".$encuesta["fechaHoraInicio"]."</td>
        <td>".$encuesta["fechaHoraFinal"]."</td>";
        $arrayValores = $encuestas->getMediaValores($encuesta["id"]);
        echo "<td>".$arrayValores[0]["ValorMedio"]."</td>
        </tr>
        ";
    }
  echo "</table>";

}

?>