<table class="table">
<tr>
<th>ID</th>
<th>Name</th>
<th>Group</th>
</tr>
<? for($i=0;$i<count($teams);$i++){ ?>
 <tr>
  <td><?= $teams[$i]['id'] ?></td>
  <td><?= $teams[$i]['name'] ?></td>
  <td><?= $teams[$i]['group'] ?></td>
 </tr>
 <? } ?>
</table>
