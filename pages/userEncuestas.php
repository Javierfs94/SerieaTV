<?php

if ($_SESSION["perfil"] != "basico" && $_SESSION["perfil"] != "premium") {
    header("Location: index.php");
} else {
    $encuesta = Encuesta::singleton();
    if (isset($_GET["visualizarEncuesta"])) {
        $array = $encuesta->getPreguntas($_GET["visualizarEncuesta"]);
        $arrayTitulo = $encuesta->getTitulo($_GET["visualizarEncuesta"]);
        print_r($arrayTitulo);
            echo "<table>";
            echo "<caption>'".$arrayTitulo[0]."'</caption>";
            echo "<tr>
            <th>Puntuación Desde Hasta</th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            </tr>";
            echo "<form method='post' action=".$_SERVER["PHP_SELF"]."?page=userEncuestas>";
                foreach ($array as $encuestasPreguntas) {
                    echo "<tr>
                        <input type='hidden' name='idPregunta' value='".$encuestasPreguntas["id"]."'>
                        <td>".$encuestasPreguntas['pregunta']."</td>";
                        echo "<td><input type = 'radio' name='puntos".$encuestasPreguntas['id']."' value='1'></td>
                        <td><input type = 'radio' name='puntos".$encuestasPreguntas['id']."' value='2'></td>
                        <td><input type = 'radio' name='puntos".$encuestasPreguntas['id']."' value='3'></td>
                        <td><input type = 'radio' name='puntos".$encuestasPreguntas['id']."' value='4'></td>
                        <td><input type = 'radio' name='puntos".$encuestasPreguntas['id']."' value='5'></td>";
                    echo "</tr>";
                }
                echo "<input type='hidden' name='idEncuesta' value='".$_GET["visualizarEncuesta"]."'>";
                echo "<input type='hidden' name='numPreguntas' value='".sizeof($array)."'>";
                echo "<input type='submit' name='enviarEncuesta' value='Enviar encuesta'>";
            echo " </form>
            </table>";
        
        } else{
            $array = $encuesta->getEncuestasDisponibles();
            echo "<h2>Encuestas disponibles</h2>";
            echo "<table>";
                echo "<tr>
                <th>Titulo</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                </tr>";
                echo "<form metho='post' action=".$_SERVER["PHP_SELF"]."?page=userEncuestas>";
                    foreach ($array as $encuestas) {
                        echo "<tr>";
                            echo "<td>".$encuestas['Titulo']."</td>";
                            echo "<td>".$encuestas['fechaHoraInicio']."</td>";
                            echo "<td>".$encuestas['fechaHoraFinal']."</td>";
                            echo "<td><button id='visualizarEncuesta'><a href="."index.php?page=userEncuestas&visualizarEncuesta=".$encuestas["id"].">Realizar encuesta</a></button></td>";                        
                            echo "</tr>";
                    }
                echo "</table>";
        }

        if (isset($_POST["enviarEncuesta"])) {
            $respuesta = Encuesta::singleton();
                $datos = array(
                    "idEncuestaPregunta"=> $_POST["idPregunta"],
                    "valor"=> $_POST["puntos".$_POST["idPregunta"]]
                );
echo "<pre>";
print_r($datos);
echo "</pre>";

        //    $respuesta->setRespuestas($datos);
        }

}

?>