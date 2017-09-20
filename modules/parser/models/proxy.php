<?php
/**
 * Created by PhpStorm.
 * User: Manager
 * Date: 12.07.2017
 * Time: 17:48
 */

namespace app\modules\parser\models;


class proxy
{
    public $proxy;
    public $proxyauth = 'luckeri:celopasy';
    /*
     * test proxys
     */
    public function testProxy()
    {
        header('X-Accel-Buffering: no');
        $url = 'https://www.google.com.ua';
        $sql = '
            SELECT id, proxy
            FROM proxy
        ';
        $proxy = \Yii::$app->db
            ->createCommand($sql)
            ->queryAll();
        $mh = curl_multi_init();
        $channels = [];
        for ($i=0; $i<count($proxy); $i++) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            curl_setopt($ch, CURLOPT_PROXY, $proxy[$i]['proxy'].':1080');
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxyauth);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
            curl_multi_add_handle($mh, $ch);
            $channels[$i] = $ch;
        }
        //запускаем дескрипторы
        $running = null;
        do {
            curl_multi_exec($mh, $running);
            /*echo $running;
            echo '<br>';
            ob_flush();
            flush();*/
        } while ($running);


        for ($i=0; $i<count($channels); $i++) {
            $res = curl_multi_getcontent($channels[$i]);
            if ($res) {
                \Yii::$app->db
                    ->createCommand("UPDATE `proxy` SET `working`='1' WHERE (`id`='{$proxy[$i]['id']}')")
                    ->execute();
            } else {
                \Yii::$app->db
                    ->createCommand("UPDATE `proxy` SET `working`='0' WHERE (`id`='{$proxy[$i]['id']}')")
                    ->execute();
            }
            curl_close($channels[$i]);
        }

    }
}