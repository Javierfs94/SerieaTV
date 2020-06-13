<?php
/**
 * Limpia los datos pasados como parametro
 */
function limpiarDatos($datos){
    $datos = trim($datos); // Elimina espacios antes y después de los datos
    $datos = stripslashes($datos); // Elimina backslashes
    $datos = htmlspecialchars($datos); // Traduce caracteres especiales en entidades HTML
    
    return $datos; // Devuelve la información limpiada
}
?>