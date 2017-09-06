<?php
/**
 * Created by PhpStorm.
 * User: Manager
 * Date: 22.08.2017
 * Time: 13:17
 */

namespace app\modules\parser\models;


class ParsingAbstractClass extends insertEventsModel
{
    //protected $count = 100;
    protected $mh;
    protected $proxyauth;
    protected $headers;
    protected $base;
    protected $useproxy;
    protected $bukid;
    /**
     * ParsingAbstractClass constructor.
     */
    function __construct($bukid)
    {
        $this->bukid = $bukid;
        \Yii::$app->db
            ->createCommand("
                    UPDATE  `bukcontor`
                    SET  `parsing` =  1
                    WHERE  `bukcontor`.`id` = :id;", [
                ':id' => $this->bukid,
            ])->execute();
        $this->useproxy = 1;
        $this->mh = curl_multi_init();
        $this->proxyauth = 'luckeri:celopasy';
        $url = \Yii::$app->db
            ->createCommand('
                SELECT `url` FROM  `bukcontor` 
                WHERE `id` = :id', [
                ':id' => $bukid,
            ])->queryScalar();
        $redirectUrl = $this->getBaseUrl($url);
        if (!empty($redirectUrl)) {
            \Yii::$app->db
                ->createCommand("
                    UPDATE  `bukcontor`
                    SET  `url` =  '" . $redirectUrl . "'
                    WHERE  `bukcontor`.`id` = :id;", [
                    ':id' => $bukid,
                ])->execute();
            $this->base = $redirectUrl;
            $this->headers = $this->getHeaders($redirectUrl);
        } else {
            $this->base = $url;
            $this->headers = $this->getHeaders($url);
        }
    }
    /**
     * ParsingAbstractClass desctuctor.
     */
    function __destruct()
    {
        \Yii::$app->db
            ->createCommand("
                    UPDATE  `bukcontor`
                    SET  `parsing` =  0
                    WHERE  `bukcontor`.`id` = :id;", [
                ':id' => $this->bukid,
            ])->execute();
        curl_multi_close($this->mh);
    }
    /**
     * @return array proxys
     */
    protected function getProxy()
    {
        $sql = '
            SELECT *
            FROM proxy
            WHERE working = 1
        ';
        $proxy = \Yii::$app->db
            ->createCommand($sql)
            ->queryAll();
        return $proxy;
    }

    /**
     * @param $allUrls array for multi curl
     * @return array curl resources for this urls
     */
    public function proceedUrls($urls)
    {
        $channels = [];
        $proxy = $this->getProxy();
        foreach ($urls as $key => $url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url['href']);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            if ($this->useproxy) {
                curl_setopt($ch, CURLOPT_PROXY, $proxy[$key % count($proxy)]['proxy'] . ':8080');
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxyauth);
            }
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 40);
            curl_multi_add_handle($this->mh, $ch);
            $channels[$key] = $ch;
        }

        $active = null;
        //запускаем дескрипторы
        do {
            $mrc = curl_multi_exec($this->mh, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        while ($active && $mrc == CURLM_OK) {
            if (curl_multi_select($this->mh) == -1) {
                usleep(100);
            }
            do {
                $mrc = curl_multi_exec($this->mh, $active);
                /*$info = curl_multi_info_read($this->mh);
                if ($info==false) {
                    echo 'false';
                } else {
                    echo '<pre>';
                    print_r($info);
                    echo '</pre>';
                }*/
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        }
        return $channels;
    }
    /*
     * Получаем куки и записывем их в заголовок
     */
    public function getHeaders($url)
    {
        stream_context_set_default([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]);
        $headers = [];
        $setHeaders = get_headers($url);
        foreach($setHeaders as $header){
            if(strpos($header,'Set-Cookie:') !== false){
                $headers[] = str_replace('Set-Cookie:', 'Cookie:', $header);
            }
        }
        $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36';
        $headers[] = "Accept-Encoding: gzip, deflate, sdch, br";
        $headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8";
        $headers[] = "Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4";
        $headers[] = "Connection: keep-alive";
        return $headers;
    }
    /*
     * Получаем урл с контентом
     *@param string $url урл
     *@return string $redirectUrl урл на который редиректит $url
     */
    public function getBaseUrl($url)
    {
        $redirectUrl = $url;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
        $user_agent = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36';
        $header = [
            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
            "Accept-Encoding: gzip, deflate, sdch, br",
            "Upgrade-Insecure-Requests: 1",
            "Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4",
            "Connection: keep-alive"
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);
        curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
        if (isset($info['redirect_url'])) {
            $redirectUrl = $info['redirect_url'];
        }
        return $redirectUrl;
    }
}