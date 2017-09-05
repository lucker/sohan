<table class="table table-bordered">
  <tr>
   <th>№</th>
   <th>name</th>
   <th>delete</th>
  </tr>
<? for($i=0;$i<count($leages);$i++){ ?>
  <tr>
   <td><?= $leages[$i][id] ?></td>
   <td ondblclick="change(this,<?= $leages[$i][id] ?>);">
    <a href="/admin/seasons/index?id=<?= $leages[$i][seasons] ?>"><?= $leages[$i][name] ?></a>
   </td>
   <td>
	   <form action="/admin/leages/deleteleage" method="POST">
	  <input type="submit" value="delete">
	  <input type="hidden" value="<?= $leages[$i][id] ?>" name="id">
	 </form>
   </td>
  </tr>
<? } ?>
</table>
<form action="/admin/leages/addleage" method="POST">
  <input type="text" name="name" value="">
  <input type="submit" value="add">
</form>

<script type="text/javascript">
 function change(a,id)
 {
	 $(a).html('<input type="text" name="bbb" value="'+$(a).html()+'" onfocus="change2(this,'+id+')">');
 }
 function change2(a,id)
 {
	$(a).keypress(function(){
     if(event.keyCode==13)
	 {
	   $(a).parent().html($(a).val());
		 $.post( "/admin/leages/changeleage", { name: $(a).val(), id: id } );
	 }
    });

 }
</script>