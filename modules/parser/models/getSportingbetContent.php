<?php
/**
 * Created by PhpStorm.
 * User: luckeri20
 * Date: 10.06.2017
 * Time: 12:31
 */

namespace app\modules\parser\models;


class getSportingbetContent
{
    public $base;
    public $headers;
    public function __construct()
    {
        $url = \Yii::$app->db
            ->createCommand('
                SELECT `value` FROM  `settings` 
                WHERE `id` = :id', [
                ':id' => 1,
            ])->queryScalar();
        $redirectUrl = $this->getBaseUrl($url);
        if(!empty($redirectUrl)) {
            \Yii::$app->db
                ->createCommand("
                    UPDATE  `settings` 
                    SET  `value` =  '" . $redirectUrl . "' 
                    WHERE  `settings`.`id` = :id;", [
                    ':id' => 1,
                ])->execute();
            $this->base = $redirectUrl;
            $this->headers = $this->getHeaders($redirectUrl);
        } else {
            $this->base = $url;
            $this->headers = $this->getHeaders($url);
        }
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
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
        $user_agent = 'User-Agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36';
        $header = array(
            "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
            "Accept-Encoding:gzip, deflate, sdch, br",
            "Upgrade-Insecure-Requests:1",
            "Accept-Language:ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4",
            "Connection:keep-alive");
        curl_setopt($curl ,CURLOPT_HTTPHEADER, $header );
        curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);
        curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
        if(isset($info['redirect_url'])){
            $redirectUrl = $info['redirect_url'];
        }
        return $redirectUrl;
    }
    /*
     * Получаем куки и записывем их в заголовок
     */
    public function getHeaders($url)
    {
        stream_context_set_default( [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]);
        $headers = [];
        $setHeaders = get_headers($url);
        foreach($setHeaders as $header){
            if(strpos($header,'Set-Cookie:') !== false){
                $headers[] = str_replace('Set-Cookie:','Cookie:',$header);
            }
        }
        $headers[] = 'User-Agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36';
        $headers[] = "Accept-Encoding:gzip, deflate, sdch, br";
        $headers[] = "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8";
        $headers[] = "Accept-Language:en-US,en;q=0.8,ru;q=0.6";
        $headers[] = "Connection:keep-alive";

        return $headers;
    }

}