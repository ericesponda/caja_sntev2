<?php
  function genera_random($length = 15) {
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	}
  $token=genera_random(5);
?>
  <form id="form_login">
    <input type="hidden" id="token"  name="token" class="form-control" placeholder="token" value='<?php echo $token; ?>' required autofocus>

    <div class="input-group mb-3">
      <input type="text" id="userAcceso"  name="userAcceso" class="form-control" placeholder="Usuario" required autofocus>
    </div>

    <div class="input-group mb-3">
    <input type="password" id="passAcceso" name="passAcceso" class="form-control" placeholder="Contraseña" required autocomplete="on">
    </div>

    <div class="d-grid gap-2">
      <button class="btn btn-warning btn-block" type="submit">Ingresar</button>
      <button class="btn btn-warning btn-block" type='button' xc='btn' xf='recuperar'>Recuperar</button>
    </div>
  </form>
