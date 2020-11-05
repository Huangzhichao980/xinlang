<?php
namespace panthsoni\xinlang\weibo;

use panthsoni\xinlang\weibo\lib\WeiboClient;

class Weibo
{
    protected static $options = [];
    public function __construct($options=[]){
        self::$options = $options;
    }

    /**
     * 初始化
     * @param array $options
     * @param string $method
     * @param string $requestWay
     * @return WeiboClient
     * @throws \Exception
     */
    public static function init($options=[],$method='',$requestWay='POST'){
        self::$options = array_merge(self::$options,$options);
        if (!self::$options) throw new \Exception('授权参数配置有误',-10014);
        return new WeiboClient(self::$options,$method,$requestWay);
    }
}