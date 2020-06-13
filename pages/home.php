<?php
echo '
<h1>¡Bienvenido/a a nuestra plataforma!</h1>
<p><button><a href="index.php?page=register">Registrese</a></button></p>
';

imprimeSeriesInvitada($_SESSION["serie"]->mostrarSeriesOrdenadas());

?>    

