<div class="container">
<h1>Регистрация на сайте sohan.xyz</h1>
<div class="col-md-12">

</div>
 <form action="/site/registration" method="POST">
  <div class="form-group">
    <label for="email">Ваш почтовый адрес:</label>
	  <input type="email" class="form-control" id="email" name="RegistrationForm[email]" value="  <?= $model->email ?>" required>
  </div>
  
  <div class="form-group">
    <label for="login">Логин:</label>
	  <input type="text" class="form-control" id="login" name="RegistrationForm[login]" value="  <?= $model->login ?>" required>
  </div>
  
  <div class="form-group">
    <label for="pwd">Пароль:</label>
    <input type="password" class="form-control" id="pwd" name="RegistrationForm[password]" value="<?= $model->password ?>" required>
  </div>
  <button type="submit" class="btn btn-default">Регистрация</button>
 </form>
</div>