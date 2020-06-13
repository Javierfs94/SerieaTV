<?php

if (isset($_POST["register"])) {
  $datos = array(
      'nombre' => $_POST["nombre"],  
      'usuario' => $_POST["usuario"],
      'passwd' => $_POST["password"]
  );
  
    $_SESSION["user"]->set($datos);
    echo $_SESSION["user"]->getMensaje();
}

echo "<form method='post' action=".$_SERVER["PHP_SELF"]."?page=register"." name='signin-form'>
  <div class='form-element'>
      <label>Nombre</label>
      <input type='text' name='nombre' required />
  </div>

  <div class='form-element'>
    <label>Usuario</label>
    <input type='text' name='usuario' required />
  </div>

  <div class='form-element'>
    <label>Password</label>
    <input type='password' name='password' required />
  </div>
  
  <button type='submit' name='register' value='login'>Crear cuenta</button>
</form>";
?>