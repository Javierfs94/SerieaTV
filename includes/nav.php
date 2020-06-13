<?php
// Menu
if ($_SESSION['perfil'] == "admin") {
    echo '<nav>
<ul>
    <li><a href="index.php?page=adminCrearEncuestas">Crear nueva encuestas</a></li>
    <li><a href="index.php?page=adminVerEncuestas">Ver Encuestas terminadas</a></li>
</ul>
</nav>';
}elseif ($_SESSION['perfil'] == "basico" || $_SESSION['perfil'] == "premium") {
    echo '<nav>
<ul>
<li><a href="index.php?page=userSeries">Mis series</a></li>
<li><a href="index.php?page=userEncuestas">Encuestas</a></li>
<li><a href="index.php?page=userPago">Pago</a></li>
</ul>
</nav>';
}else {
    echo '<nav>
<ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="index.php?page=login">Login</a></li>
    <li><a href="index.php?page=register">Registrarse</a></li>
</ul>
</nav>';
}
?>    
