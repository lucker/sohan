<h2>Вилки - на победу команды</h2>
<?
    $events = [1=>'1', 2=>'X', 3=>'2'];
    ?>
    <? for($i=0; $i<count($data); $i++) { ?>
        <table class="table table-bordered">
            <tr>
                <th class="danger"><?= $data[$i]['procent'] ?>%</th>
                <th colspan="3" class="info">
                    Футбол <?= date("d-m-Y H:i:s", strtotime($data[$i]['date'])); ?>
                </th>
            </tr>
            <? for($j=1; $j<=3; $j++) { ?>
                <tr>
                    <td> <?= $data[$i]['data'][$j]['bukname'] ?></td>
                    <td>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12"><b><?= $data[$i]['data'][$j]['leage'] ?></b></div>
                                <div class="col-md-12">
                                    <a target="_blank" href = "<?= $data[$i]['data'][$j]['url'] ?>">
                                    <?= $data[$i]['data'][$j]['team1'] ?> - <?= $data[$i]['data'][$j]['team2'] ?>
                                    </a>
                                </div>
                                <div class="col-md-12">
                                    <span style="color:green;font-size: 15px;">
                                        Коэффициенты актуальные на <?= date("d-m-Y H:i:s",strtotime($data[$i]['data'][$j]['update_date'])) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td style="min-width: 100px;"><?= $events[$j] ?></td>
                    <td style="min-width: 100px;"><?= $data[$i]['data'][$j]['odd'] ?></td>
                </tr>
            <? } ?>
        </table>
    <?} ?>
