<div class="container">
<h1>Стратегии и системы ставок на футбол</h1>
 <? for($i=0;$i<count($posts);$i++){ ?>
  <div class="col-md-4">
   <img src="">
  </div>
  <div class="col-md-12" style="border: solid 2px black;border-width: 1px;">
  <h2 style="background-color:green;">
  <a href="<?= '/articles/'.$posts[$i]['url'] ?>" style="color:white;">
  <?= $posts[$i]['title'] ?>
  </a>
  </h2>
   <?= $posts[$i]['text'] ?>
  </div>
  <div class="col-md-12"><hr></div>
 <? } ?>
</div>