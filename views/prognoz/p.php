<div class="container">
    <h1> Создать прогноз на матч </h1>
        <form method="POST" action="/prognoz/addp">
   <div class="form-group">
         <label for="SelectL">Выберите чемпионат</label>
	  <select id="SelectL" class="form-control" onchange="matchesi(this)" name="leage">
		   <option value="-1">Не выбран</option>
		  <? for($i=0;$i<count($leages);$i++){ ?>
           <option value="<?= $leages[$i]['id'] ?>"><?= $leages[$i]['name'] ?></option>
		  <? } ?>
	  </select>
   </div>
  
    <div class="form-group">
    <label for="SelectM">Выберите матч</label>
	  <select id="SelectM" class="form-control" onchange="rates(this)" name="match">
      <option value="-1">Не выбран</option>
    </select>
    </div>
    
   <div class="form-group" id="money">
    Ваша ставка: <select name="money">
    <? for($i=100;$i<$money->money;$i=$i+100){ ?>
     <option value="<?= $i ?>"> <?= $i ?> </option>
    <? } ?>
    </select>
   </div>

   <div id="SelectR">
   </div>

  <div class="form-group">
   <label for="editor1">Текст прогноза</label>
   <textarea class="form-control" rows="5" id="editor1" name="editor1"></textarea>
  </div>
            <script>CKEDITOR.replace( 'editor1' );</script>
            <input type="submit" value="Добавить прогноз" class="btn btn-primary">
        </form>
</div>
<script type="text/javascript">
  function matchesi(a)
  {
	 $.ajax({
       method: "POST",
	   url: "/prognoz/matches",
       data: { leage: $(a).val() }
     }).done(function( msg ) {
		var html='<option value="-1">Не выбран</option>';
        var obj = jQuery.parseJSON( msg );
        for(var i=0;i<obj.length;i++)
		{
		   html += '<option value="'+obj[i].id+'">'+obj[i].team1+'-'+obj[i].team2+'</option>';
		}
		 $("#SelectM").html(html);
     });
  }

  function rates(a)
  {
	 $.ajax({
       method: "POST",
	   url: "/prognoz/rates",
       data: { match: $(a).val() }
     }).done(function( msg ) {
		var html='<table class="table table-bordered"><tr>';
        var obj = jQuery.parseJSON( msg );
		  console.log(obj);
		for(var i=0;i<obj.length;i++)
		{
			html = html+'<th>'+obj[i].name+'</th>';
			if( obj[i].G==prev ){ continue; }
			switch( obj[i].G )
			{
			 case "2": html = html+'<th> Фора </th>'; break; 
			 case "15": html = html+'<th> Ит1 </th>'; break;
			 case "17": html = html+'<th> Тотал </th>'; break;
			}
			var prev = obj[i].G;
		}
		html = html +'</tr><tr>';
		for(var i=0;i<obj.length;i++)
		{			
		    html = html+'<td><input type="radio" name="rates" value="'+obj[i].id+'">'+obj[i].C+'</td>';
			if( obj[i].G==prev ){ continue; }
			if( obj[i].T>6 ){  html = html+'<td>'+obj[i].P+'</td>'; }
			var prev = obj[i].G;
		}
		html = html +'</tr></table>';
		$("#SelectR").html(html);
     });
  }
</script>
