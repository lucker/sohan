<head>
 <meta charset="utf-8">
 <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
 <!-- Latest compiled and minified CSS -->
 <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
 <!-- Optional theme -->
 <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
 <!-- Latest compiled and minified JavaScript -->
 <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</head>
<body>
  <!-- menu -->
  <div class="container">
  <h1>Админка</h1>
   <ul class="nav nav-pills">
	<li><a href="/admin">Главная</a></li>
    <li <? if( $this->params['page'] == 1 ){ echo 'class="active"'; } ?>><a href="/admin/leages/index">Лиги</a></li>
    <li <? if( $this->params['page'] == 2 ){ echo 'class="active"'; } ?>><a href="/admin/matches/add">Добавить Матчи</a></li>
	<li <? if( $this->params['page'] == 3 ){ echo 'class="active"'; } ?>><a href="/admin/teams/index">Добавить Команды</a></li>
    <li <? if( $this->params['page'] == 4 ){ echo 'class="active"'; } ?>><a href="/admin/matches/points">Ввести счет игры</a></li>
    <li <? if( $this->params['page'] == 5 ){ echo 'class="active"'; } ?>><a href="/admin/teams/all">Все команды</a></li>
    <li  <? if( $this->params['page'] == 6 ){ echo 'class="active"'; } ?>>
     <a href="/admin/rates">Добавить коефициент к матчу</a>
    </li>
   </ul>
  </div>
  <!-- menu -->
	 <?= $content ?>
</body>