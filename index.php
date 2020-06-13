<?php
/*
* Titulo: Secretaría Virtual
* Descripcion: Ejercicio de Gestión de una Secretaría Virtual
* Autor: Francisco Javier Frías Serrano
*/
?>

<?php
    include "./config/config.php";
    include "./classes/Carta.php";
    include "./classes/Usuario.php";
    include "./classes/Serie.php";
    include "./classes/Encuesta.php";
    include "./includes/funciones.php";
    session_start();

if (isset($_POST["exit"])) {
    header("Location: ./includes/logout.php");
}

if (!isset($_SESSION["logged"])) {
    $_SESSION["user"] = Usuario::singleton();
    $_SESSION["serie"] = Serie::singleton();
    $_SESSION["encuesta"] = Encuesta::singleton();
    $_SESSION["logged"] = false;
    $_SESSION["perfil"] = "invitado";
    $_SESSION["idUser"] = null;
    $_SESSION["usuario"] = "";
    $_SESSION["idPlanUser"] = 0;
}

if (isset($_POST["login"])) {
    $array = $_SESSION["user"]->get($_POST["usuario"]); 
    if (sizeof($array) == 1) {
        if ($array[0]["passwd"] == $_POST["password"]) {
            $_SESSION["logged"] = true;   
            $_SESSION["idUser"] = $array[0]["id"];
            $_SESSION["usuario"] = $array[0]["usuario"];
            $_SESSION["perfil"] = $array[0]["perfil"];            
            if ($_SESSION["perfil"] == "admin") {
                header("Location: index.php?page=adminCrearEncuestas");
            } 
            if ($_SESSION["perfil"] == "basico") {
                $_SESSION["idPlanUser"] = 1;
                header("Location: index.php?page=userSeries");
            }  
            if ($_SESSION["perfil"] == "premium" ) {
                $_SESSION["idPlanUser"] = 2;
                header("Location: index.php?page=userSeries");
            }         
        }
    } else {
        header("Location: index.php?page=login");
    } 
}
  
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Francisco Javier Frías Serrano">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <title><?php echo TITULO; ?></title>
</head>

<body>
<?php
    include "./includes/cabecera.php";
if (isset($_SESSION['perfil'])) {
    include "./includes/conectado.php";
}

include "./includes/nav.php";

?>

<main>

<?php 
    if (isset($_GET["page"])){
        if (($_GET["page"]=="index")) {
            include ("index.php"); 
        }
        if (($_GET["page"]=="login")) {
            include ("./pages/login.php"); 
        }
        if (($_GET["page"]=="register")) {
            include ("./pages/register.php"); 
        }
        if (($_GET["page"]=="adminCrearEncuestas")) {
            include ("./pages/adminCrearEncuestas.php"); 
        }   
        if (($_GET["page"]=="adminVerEncuestas")) {
            include ("./pages/adminVerEncuestas.php"); 
        } 
        if (($_GET["page"]=="userPago")) {
            include ("./pages/userPago.php"); 
        }
        if (($_GET["page"]=="userSeries")) {
            include ("./pages/userSeries.php"); 
        }
        if (($_GET["page"]=="userEncuestas")) {
            include ("./pages/userEncuestas.php"); 
        }
        if (($_GET["page"]=="visualizacionSerie")) {
            include ("./pages/visualizacionSerie.php"); 
        }
    }else {
        include ("./pages/home.php");
    }
?>

</main>

<?php
    include("./includes/footer.php");
?>

</body>

</html>