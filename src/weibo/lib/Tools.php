<?php
namespace panthsoni\xinlang\weibo\lib;

use panthsoni\xinlang\common\CommonTools;

class Tools extends CommonTools
{
    public function __construct(){
        parent::__construct();
    }

    /**
     * 移除空白字符
     * @param $value
     * @return null
     */
    static public function trimString($value){
        $ret = null;
        if (null != $value) {
            $ret = $value;
            if (strlen($ret) == 0) $ret = null;
        }
        return $ret;
    }

    /**
     * 组建链接
     * @param $url
     * @param array $params
     * @param string $requestWay
     * @return string
     */
    static public function buildRequestResult($url,$params=[],$requestWay='GET'){
        $res = '';
        if ($requestWay == 'GET'){
            $url = "{$url}?";
            $counts = count($params);
            $foreachTimes = 0;
            foreach ($params as $key=>$val){
                $foreachTimes+=1;
                if ($foreachTimes == $counts){
                    $url.= "{$key}={$val}";
                }else{
                    $url.= "{$key}={$val}&";
                }
            }

            $res = $url;
        }

        if ($requestWay == 'POST') $res = self::curlPost($url,$params);

        return $res;
    }

    /**
     * POST 请求
     * @param $url
     * @param $param
     * @param int $timeout
     * @return bool|mixed
     */
    static public function curlPost($url,$param,$timeout = 30){
        $oCurl = curl_init();
        if(stripos($url,"https://") !== false){
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1);
        }

        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($oCurl, CURLOPT_POST,true);
        curl_setopt($oCurl, CURLOPT_TIMEOUT,$timeout);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS,json_encode($param));
        $sContent = curl_exec($oCurl);
        curl_close($oCurl);

        return $sContent;
    }
}