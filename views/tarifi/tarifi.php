<div class="container" style="padding-top: 30px;">
    <h1 align="center">Тарифы на сайте sohan.xyz</h1>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4">
                <table class="table table-bordered">
                    <tr>
                        <td style="text-align: center">
                            <strong>FREE тариф</strong><br>
                            0 <span class="glyphicon glyphicon-usd"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <ul>
                                <li>Вилки до 1%</li>
                                <li>Задержка 900 сек для прематча</li>
                                <li>Только 1X2</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center">
                            <button type="button" class="btn btn-primary" disabled>Выбран</button>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
            <table class="table table-bordered">
                <tr>
                    <td style="text-align: center">
                        <strong>PREMATCH тариф</strong><br>
                        <span id="tarifValue">1</span><span class="glyphicon glyphicon-usd"></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <ul>
                            <li>Базовый функционал</li>
                            <li>Вилки любой маржинальности</li>
                            <li>Основныe маркеты(Тоталы, 1X2, 1X, 12, 2X)</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group">
                            <select class="form-control" id="duration" onchange="newTarif(this)">
                                <option value="1">1 день</option>
                                <option value="2">7 дней</option>
                                <option value="3">30 дней</option>
                                <option value="4">90 дней</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center">
                        <? if(yii::$app->user->isGuest) { ?>
                            <button type="button" class="btn btn-primary" onclick="window.location='http://sohan.xyz/site/registration'">Оплатить</button>
                        <? } else { ?>
                        <form id="payment" name="payment" method="post" action="https://sci.interkassa.com/" enctype="utf-8">
                            <input type="hidden" name="ik_co_id" value="5975d3dd3b1eafff708b4567" />
                            <input type="hidden" name="ik_pm_no" value="ID_<?= Yii::$app->user->id ?>" />
                            <input type="hidden" name="ik_am" value="26" />
                            <input type="hidden" name="ik_cur" value="UAH" />
                            <input type="hidden" name="ik_desc" value="Оплата сканера" />
                            <input type="submit" class="btn btn-primary" value="Оплатить">
                        </form>
                        <? } ?>
                    </td>
                </tr>
            </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function newTarif(elem)
    {
        var tarif = $('#tarifValue');
        var tarifVal = $('[name="ik_am"');
        switch (parseInt($(elem).val())) {
            case 1:
                tarifVal.val(26);
                tarif.html(1);
                break;
            case 2:
                // перевод валюты
                tarifVal.val(6*26);
                tarif.html(6);
                break;
            case 3:
                tarifVal.val(20*26);
                tarif.html(20);
                break;
            case 4:
                tarifVal.val(40*26);
                tarif.html(40);
                break;
        }
    }
</script>