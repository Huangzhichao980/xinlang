<?php
namespace panthsoni\xinlang\weibo\lib;

class WeiboClient
{
    /**
     * 微博开放平台网关
     * @var string
     */
    protected $domain = 'https://api.weibo.com';

    /**
     * 微博接口请求地址
     * @var array
     */
    protected $way = [
        'authorize' => '/oauth2/authorize',
        'accessToken' => '/oauth2/access_token',
        'getTokenInfo' => '/oauth2/get_token_info',
        'revokeOauth' => '/oauth2/revokeoauth2',
    ];

    /**
     * 配置参数
     * @var array
     */
    protected $options=[];

    /**
     * 请求链接
     * @var string
     */
    protected $requestUrl;

    /**
     * 必传参数
     * @var array
     */
    protected $params=[];

    /**
     * 可选参数
     * @var array
     */
    protected $bizContent=[];

    /**
     * 请求方法
     * @var string
     */
    protected $method;

    /**
     * 请求方式
     * @var string
     */
    protected $requestWay;

    /**
     * WeiboClient constructor.
     * @param $options
     * @param string $method
     * @param string $requestWay
     * @param array $way
     * @throws \Exception
     */
    public function __construct($options,$method='',$requestWay='GET',$way = []){
        /*判断接口是否需要必须的配置参数*/
        $this->setOptions($options);

        /*方法名必传*/
        if (!$method){
            throw new \Exception('请求方法缺失',-10015);
        }

        /*设置第三方接口请求地址*/
        $this->way = array_merge($way,$this->way);
        if (!isset($this->way[$method]) || (isset($this->way[$method]) && !$this->way[$method])){
            throw new \Exception('请求方法未授权',-10025);
        }

        $this->method = $method;
        $this->requestWay = $requestWay;
        $this->requestUrl = $this->domain.$this->way[$method];
    }

    /**
     * 设置参数
     * @param array $options
     * @throws \Exception
     */
    public function setOptions($options=[]){
        if (empty($options) || !is_array($options)){
            throw new \Exception('请求参数缺失',-10007);
        };

        $this->options = array_merge($this->options,$options);
    }

    /**
     * 设置公共请求参数 支持数组批量设置
     * @param $param
     * @param string $paramValue
     * @return $this
     */
    public function setParam($param, $paramValue=""){
        switch (true){
            case(is_string($param) &&(is_string($paramValue)||is_numeric($paramValue)) ):
                $this->params[Tools::trimString($param)] = Tools::trimString($paramValue);
                break;
            case (is_array( $param) && empty( $paramValue)):
                foreach ($param as $item=>$value){
                    if (is_string($item) && (is_string($value) || is_numeric($value))){
                        $this->params[Tools::trimString($item)] = Tools::trimString($value);
                    }
                }
                break;
            default:
        }
        return $this;
    }

    /**
     * 设置文本参数
     * @param $param
     * @param string $paramValue
     * @return $this
     */
    public function setBizContentParam($param, $paramValue=""){
        switch (true){
            case(is_string($param) &&( is_string($paramValue)||is_numeric($paramValue)) ):
                $this->bizContent[Tools::trimString($param)] = Tools::trimString($paramValue);
                break;
            case (is_array( $param) && empty( $paramValue)):
                foreach ($param as $item=>$value){
                    if (is_string($item) && ( is_string($value)||is_numeric($value))){
                        $this->bizContent[Tools::trimString($item)] = Tools::trimString($value);
                    }
                }
                break;
            default:
        }
        return $this;
    }

    /**
     * 获取快速链接
     * @return bool|string
     * @throws \Exception
     */
    public function getResult(){
        $requestParamsList = Tools::validate(array_merge($this->options,$this->params,$this->bizContent),new SingleValidate(),$this->method);
        try {
            if (!$requestParamsList){
                throw new \Exception('请求参数缺失',-10007);
            }
        } catch (\Exception $e) {
            return false;
        }

        return Tools::buildRequestResult($this->requestUrl,$requestParamsList,$this->requestWay);
    }
}