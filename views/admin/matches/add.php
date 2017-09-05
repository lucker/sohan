<head>
 <meta charset="utf-8">
 <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
 <!--
 <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
 <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
 <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
 -->
 <!-- ... -->
 <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet"> 
<link rel="stylesheet" type="text/css" media="screen"
     href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
  <!-- -->
</head>
<body>
 <form action="/admin/matches/addi" method="POST">
   <table class="table">
    <tr>
      <td>
       <div class="form-group">
        <label for="leages">Лига</label>
        <select class="form-control" id="leages" name="leages">
        <? for($i=0;$i<count($leages);$i++){ ?>    
         <option value="<?= $leages[$i]['id'] ?>">
	      <?= $leages[$i]['name'] ?>
         </option>
        <? } ?>
        </select>
       </div>
     </td>
     <td>
       <div class="form-group">
        <label for="team1">Команда 1</label>
        <select class="form-control" id="team1" name="team1">
        <? for($i=0;$i<count($teams);$i++){ ?>    
         <option value="<?= $teams[$i]['id'] ?>">
	      <?= $teams[$i]['name'] ?>
         </option>
        <? } ?>
        </select>
       </div>
     </td>
     <td>
       <div class="form-group">
        <label for="team2">Команда 2</label>
        <select class="form-control" id="team2" name="team2">
        <? for($i=0;$i<count($teams);$i++){ ?>    
         <option value="<?= $teams[$i]['id'] ?>">
	      <?= $teams[$i]['name'] ?>
         </option>
        <? } ?>
        </select>
       </div>     
     </td>
     <td>
     
 <div class="well">    
 <div id="datetimepicker1" class="input-append date">
    <input data-format="yyyy/MM/dd hh:mm:ss" type="text" name="date"></input>
    <span class="add-on">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
 </div>
 </div>
  <script type="text/javascript">
  $(function() {
    $("#datetimepicker1").datetimepicker({
      language: "pt-BR"
    });
  });
</script>         
     </td>
    </tr>
    
   </table> 
  <button type="submit" class="btn btn-default">Submit</button>
 </form>
 <!--<button onclick="addi();">Add</button>
 
 <script type="text/javascript">
  $().append(); 
  
 </script>-->
 
     <script type="text/javascript"
     src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js">
    </script> 
    <script type="text/javascript"
     src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js">
    </script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
    </script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js">
    </script> 
</body>