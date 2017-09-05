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
<div class="container">
<form action="/admin/matches/add" method="POST">
<div class="form-group">
  <label for="leage">Лига:</label>
  <select class="form-control" id="leage" name="leage">
  <? for($i=0;$i<count($leages);$i++){ ?>    
    <option value="<?= $leages[$i]['id'] ?>">
	 <?= $leages[$i]['name'] ?>
    </option>
  <? } ?>
  </select>
</div>

<div class="form-group">
  <label for="season">Сезон:</label>
  <select class="form-control" id="season" name="season">
  <? for($i=0;$i<count($seasons);$i++){ ?>    
    <option value="<?= $seasons[$i]['id'] ?>">
	 <?= $seasons[$i]['year'] ?>
    </option>
  <? } ?>
  </select>
</div>
<input type="submit" value="Отправить">
</form>
</div>
<script type="text/javascript">
function leagesi(a)
{
	 $.ajax({
       method: "POST",
	   url: "/admin/matches/leages",
       data: { leage: $(a).val() }
     }).done(function( msg ) {
		alert(msg);
     });
}
</script>
</body>