<div class="container">
    <h1>Вход</h1>
 <form action="/site/login" method="POST">
  <div class="form-group">
    <label for="email">Логин(email):</label>
	  <input type="email" class="form-control" id="email" name="LoginForm[email]" value="<?= $model->email ?>" required>
  </div> 
  
  <div class="form-group">
    <label for="pwd">Пароль:</label>
    <input type="password" class="form-control" id="pwd" name="LoginForm[password]" value="<?= $model->password ?>" required>
  </div>
  <button type="submit" class="btn btn-default">Вход</button>
 </form>
</div>