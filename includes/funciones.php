<?php

function imprimeSeries($resultados){
    foreach ($resultados as $serie) {
        echo "<p>
        <h2>".$serie["titulo"]."</h2>
        <p><img src=./img/".$serie["caratula"]." alt='Imagen de la serie' width='250' height='250'></p>
        <p>Reproducciones: ".$serie["numero_reproducciones"]."</p>";
        if ($serie["id_plan"] == 1) {
            echo "<p>Plan : Básico</p>";
        } else {
            echo "<p>Plan : Premium</p>";
        }
        echo "<button id='desFverSerieavorito'><a href="."index.php?page=userSeries&verSerie=".$serie["id"].">Ver Serie</a></button>"; 
    }
}

function imprimeSeriesInvitada($resultados){
    foreach ($resultados as $serie) {
        echo "<p>
        <h2>".$serie["titulo"]."</h2>
        <p><img src=./img/".$serie["caratula"]." alt='Imagen de la serie' width='250' height='250'></p>
        <p>Reproducciones: ".$serie["numero_reproducciones"]."</p>";
        if ($serie["id_plan"] == 1) {
            echo "<p>Plan : Básico</p>";
        } else {
            echo "<p>Plan : Premium</p>";
        }
    }
}


?>