<?php
/**
 * Created by PhpStorm.
 * User: Manager
 * Date: 22.08.2017
 * Time: 13:17
 */

namespace app\modules\parser\models;


class ParsingAbstractClass extends insertEvents
{
    //protected $count = 100;
    protected $mh;
    protected $proxyauth;
    protected $headers;
    protected $base;
    protected $bukid;
    /**
     * ParsingAbstractClass constructor.
     */
    function __construct($bukid)
    {
        parent::__construct();
        $this->bukid = $bukid;
        // time zone
        date_default_timezone_set('Etc/GMT-3');
        \Yii::$app->db
            ->createCommand("
                    UPDATE  `bukcontor`
                    SET  `parsing` =  1
                    WHERE  `bukcontor`.`id` = :id;", [
                ':id' => $this->bukid,
            ])->execute();
        $this->mh = curl_multi_init();
        $this->proxyauth = 'luckeri:celopasy';
        $url = \Yii::$app->db
            ->createCommand('
                SELECT `url` FROM  `bukcontor` 
                WHERE `id` = :id', [
                ':id' => $bukid,
            ])->queryScalar();
        $this->headers = $this->getHeaders($url);
        $this->base = $url;
    }
    /**
     * ParsingAbstractClass desctuctor.
     */
    function __destruct()
    {
        parent::__destruct();
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
        $proxy = [];
        foreach ($this->headers as $key => $val) {
            $proxy[] = $key;
        }
        foreach ($urls as $key => $url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url['href']);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers[$proxy[$key%count($proxy)]]);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_PROXY, $proxy[$key % count($proxy)].':8080');
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxyauth);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
            // curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_multi_add_handle($this->mh, $ch);
            $channels[$key] = $ch;
        }
        //запускаем дескрипторы
        $running = null;
        do {
            curl_multi_exec($this->mh, $running);
            curl_multi_select($this->mh);
        } while ($running);
        return $channels;
    }
    /*
     * Получаем куки и записывем их в заголовок по каждому проксику
     */
    public function getHeaders($url)
    {
        $headers = [];
        $channels = [];
        $proxy = $this->getProxy();
        foreach ($proxy as $key => $val) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            $user_agent = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36';
            $header = [
                "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
                "Accept-Encoding: gzip",
                "Upgrade-Insecure-Requests: 1",
                "Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4",
                "Connection: keep-alive"
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_PROXY, $proxy[$key]['proxy'].':8080');
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxyauth);
            // curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_multi_add_handle($this->mh, $ch);
            $channels[$key] = $ch;
        }
        // запускаем дескрипторы
        $running = null;
        do {
            curl_multi_exec($this->mh, $running);
            curl_multi_select($this->mh);
        } while ($running);
        // обрабатываем
        foreach ($channels as $key => $channel) {
            $out = curl_multi_getcontent($channel);
            $info = curl_getinfo($channel);
            $header = substr($out, 0, $info['header_size']);
            //$body = substr($out, $info['header_size'])
            /*echo $out;
            echo '<pre>';
            print_r($info);
            echo '</pre>';*/
            if ($info['http_code']==200) {
                preg_match_all('/Set-Cookie: .{1,};/', $header, $matches);
                foreach ($matches[0] as $match) {
                    $headers[$proxy[$key]['proxy']][] = str_replace('Set-Cookie:', 'Cookie:', $match);
                }
                $headers[$proxy[$key]['proxy']][] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36';
                $headers[$proxy[$key]['proxy']][] = "Accept-Encoding: gzip";
                $headers[$proxy[$key]['proxy']][] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8";
                $headers[$proxy[$key]['proxy']][] = "Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4";
                $headers[$proxy[$key]['proxy']][] = "Connection: keep-alive";
                $headers[$proxy[$key]['proxy']][] = "Upgrade-Insecure-Requests: 1";
            }
            curl_multi_remove_handle($this->mh, $channel);
            curl_close($channel);
        }
        return $headers;
    }
}