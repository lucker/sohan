<? if(!isset($_GET['p'])){ $_GET['p']=1; } ?>
<div class="container">
<? for($i=($_GET['p']-1)*15;$i<count($p)&&$i<$_GET['p']*15;$i++){ ?>
<h3><a href="/prognoz/<?= $p[$i]['id'] ?>">Прогноз на матч <?= $p[$i][t1] ?> - <?= $p[$i][t2] ?> </a> <span class="label label-success"><?= $p[$i]['leage'] ?></span></h3>
 <div class="row">
 <div class="col-md-12">
   Прогноз: <b><?= $p[$i]['ratename'] ?></b> Коэффициент: <b><?= $p[$i]['C'] ?></b>  Сумма ставки: <b><?= $p[$i]['sum'] ?></b>
 </div>
  <div class="col-md-12">
  <?= $p[$i]['text'] ?>
  </div>
 </div>
 <div class="col-md-12">
 <span style="font-size:18px;"><span class="glyphicon glyphicon-calendar"></span> <?= $p[$i]['date'] ?> от
 <a href="/site/sort?user_id=<?= $p[$i]['author'] ?>"> <span class="glyphicon glyphicon-user"></span>  <?= $p[$i]['name'] ?> </a> </span></div>
 <div class="col-md-12"><hr></div>
<? } ?>



<ul class="pagination">
<? $j=0; ?>
<? for($i=0;$i<count($p);$i=$i+15){ $j++; ?>
   <li><a href="/prognoz/view?p=<?= $j ?>"><?= $j ?></a></li> 
<? } ?>
</ul>

<div class="col-md-12">
Прогнозы на футбол это сложное дело так как требует учет многих параметров. Обилие футбольных прогнозов в интернете заставляет многих задуматься каким из прогнозов верить, а каким нет. Сайт sohan.xyz предоставляет пользователям возможность просмотреть ставки того или иного прогнозиста и тем самым узнать стоит ли ему верить. Если проходимость ставок больше 70%, то данному пользователю стоит доверять и прислушиваться к его футбольным прогнозам. 
</div>

</div>