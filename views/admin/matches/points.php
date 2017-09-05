<form action="/admin/matches/addpoints" method="POST">
 <table class="table">
  <? for($i=0;$i<count($matches);$i++){ 
   if(empty($matches[$i]['team2_name'])){ continue; }
  ?>
  <tr>
   <td> <?= $matches[$i]['leage_name']; ?> </td>
   <td> <?= $matches[$i]['team1_name']; ?> </td>
   <td> <?= $matches[$i]['team2_name']; ?> </td>
   <td> <input type="text" name="score1[]">  </td>
   <td> <input type="text" name="score2[]">  </td>
   <td> <?= $matches[$i]['date']; ?> </td>
    <input type="hidden" name="id[]" value="<?= $matches[$i]['id'] ?>">
    <input type="hidden" name="team1[]" value="<?= $matches[$i]['team1'] ?>">
    <input type="hidden" name="team2[]" value="<?= $matches[$i]['team2'] ?>">
   </tr>
  <? } ?>
 </table>
 <input type="submit" value="submit">
</form>