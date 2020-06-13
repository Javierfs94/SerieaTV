<?php

if ($_SESSION["perfil"] != "admin") {
  header("Location: index.php");
}else {
 
  echo "<h1>Nueva encuesta</h1>
  <form method='post' action=".$_SERVER["PHP_SELF"]."?page=adminCrearEncuestas>
  <p><input type='submit' name='nuevaEncuesta' value='Nueva encuesta'></p>  
  </form>";

if (isset($_POST["nuevaEncuesta"])) {
  echo "<h1>Datos nueva encuesta</h1>
  <form method='post' action=".$_SERVER["PHP_SELF"]."?page=adminCrearEncuestas>
  <p>Titulo: <input type='text' name='Titulo'></p>
  <p>Fecha Inicio:<input type='datetime-local' name='fhInicio'></p>
  <p>Fecha Final:<input type='datetime-local' name='fhFinal'></p>
  <p>Cantidad de Preguntas: <input type='number' min='1' name='cantidadPreguntas'></p>
  <p><input type='submit' name='crearEncuesta' value='Crear encuesta'></p>  
  </form>";
}


  if (isset($_POST["crearEncuesta"]) && isset($_POST["cantidadPreguntas"]) && $_POST["cantidadPreguntas"] > 0) {
    $datos = array(
      'Titulo' => $_POST["Titulo"],  
      'fechaHoraInicio' => $_POST["fhInicio"],
      'fechaHoraFinal' => $_POST["fhFinal"]
    );
    $_SESSION["encuesta"]->setEncuesta($datos);

    echo "<h1>Preguntas de la encuesta</h1>
    <form method='post' action=".$_SERVER["PHP_SELF"]."?page=adminCrearEncuestas>
    <p><input type='hidden' name='encuestaPadre' value='".$_SESSION["encuesta"]->getEncuestas()[0]["id"]."'></p>
    <p><input type='hidden' name='cantidadPreguntas' value='".$_POST["cantidadPreguntas"]."'></p>";
    for ($i=0; $i < $_POST["cantidadPreguntas"]; $i++) { 
        echo 'Pregunta '.($i+1).': <input type="text" name="pregunta'.$i.'"><br>';
    }
    echo "<p><input type='submit' name='enviarTodo' value='Nuevas preguntas'></p>  
    </form>";
  } 


  if(isset($_POST["enviarTodo"])){
    for ($i = 0; $i < $_POST["cantidadPreguntas"]; $i++) {
      if ($_POST["pregunta".$i] != "") {
        $pregunta = Encuesta::singleton();
        $datos = array(
            "idEncuesta"=> $_POST["encuestaPadre"],
            "pregunta"=> $_POST["pregunta".$i]
        );
        $pregunta->setPreguntas($datos); 
      } 
    }
  }



}


?>