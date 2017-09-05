<table class="table table-bordered">
  <tr>
   <th>№</th>
   <th>name</th>
   <th>delete</th>
  </tr>
<? for($i=0;$i<count($seasons);$i++){ ?>
 <tr>
	 <td><?= $i+1 ?></td>
	 <td><?= $seasons[$i][year] ?></td>
	 <td>button</td>
 </tr>
<? } ?>
</table>