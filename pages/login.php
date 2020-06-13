<?php
  echo "<form method='post' action=".$_SERVER["PHP_SELF"]." name='signin-form'>
  <div class='form-element'>
      <label>Usuario</label>
      <input type='text' name='usuario' pattern='[a-zA-Z0-9]+' required />
  </div>
  <div class='form-element'>
      <label>Password</label>
      <input type='password' name='password' required />
  </div>
  <button type='submit' name='login' value='login'>Log In</button>
</form>";
?>