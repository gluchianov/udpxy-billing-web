<?php	if ($LoginError==true){ ?>
<div class="alert alert-dismissable alert-danger balert">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>Ошибка авторизации!</strong><br /> 
  Вы ввели неправильный <em>логин</em> и/или <em>пароль</em>!.
</div>
<?php } ?>

<form action="" method="POST" class="form-signin" role="form">
<h2 class="form-signin-heading">Авторизация</h2>
<input name="login" type="login" class="form-control" placeholder="Login" required autofocus>
<input name="pass" type="password" class="form-control" placeholder="Password" required>
<input name="LoginSubmit" type="submit" class="btn btn-lg btn-primary btn-block" value="Войти" >
</form>