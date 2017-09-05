<div class="container" itemscope itemtype="http://schema.org/Article">
<? for($i=0;$i<count($p);$i++){ ?>
<h3 itemprop="headline">Прогноз на матч <?= $p[$i][t1] ?> - <?= $p[$i][t2] ?> | <?= $p[0]['dd'] ?> <span class="label label-success"><?= $p[$i]['leage'] ?></span></h3>
 <div class="row">
  <div class="col-md-12" itemprop="articleBody">
  <?= $p[$i]['text'] ?>
  </div>
 </div>
 <div class="col-md-12">
 <span style="font-size:18px;"><span class="glyphicon glyphicon-calendar"></span> <time datetime="<?= $p[$i]['date'] ?>" itemprop="datePublished"><?= $p[$i]['date'] ?></time> от <span itemprop="author">
 <a href="/site/sort?user_id=<?= $p[$i]['author'] ?>"> <span class="glyphicon glyphicon-user"></span> <?= $p[$i]['name'] ?> </a> </span> </span>


 
 </div>
 <div class="col-md-12"><hr>
 </div>
<? } ?>
</div>
<script type="text/javascript">
function raiting(x)
{	
  $.cookie(<?= $p[0]['id'] ?>, 'yes');
  $.ajax({
   method: "POST",
   url: "/prognoz/prate",
   data: { val: x, id: <?= $p[0]['id'] ?> }
  })
   .done(function( msg ) {
	   //alert(msg);
     $("#res").html('');
     for(var i=1;i<=msg;i++)
	 { 
	  $("#res").append('<span class="glyphicon glyphicon-star"></span>'); 
	 }
  });

}

function focusi(x)
{
  for(var i=1;i<=x;i++){ $('#'+i).css('color','yellow'); }
}

function clearstate()
{
  for(var i=1;i<=5;i++){ $('#'+i).css('color','black'); }
}
</script>