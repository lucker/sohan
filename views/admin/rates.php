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
<form action="/admin/rateadd" method="POST">
     <h2> Matches </h2>
     <select class="form-control" id="leages" name="match_id">
     <? for($i=0;$i<count( $matches );$i++){ ?>
      <option value="<?= $matches[$i]['id'] ?>">
	  <?= $matches[$i]['team1_name'] ?> - <?= $matches[$i]['team2_name'] ?>
      </option>
      <? } ?>
     </select>
    <h2> Rates </h2>
    <select class="form-control" id="rates" name="rate_id">
    <? for($j=0;$j<count($rates);$j++){ ?>
     <option value="<?= $rates[$j]['id'] ?>"> <?= $rates[$j]['about'] ?> </option>
    <? } ?>
   </select>
   <div class="col-md-12">
    <h2>Значение коефициента</h2>
    <input type="text" name="rate">
   </div>
   <div class="col-md-12" style="margin-top:5px;">
    <input type="submit" value="submit">
   </div>
</form>
</body>