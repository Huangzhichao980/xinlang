<?php
namespace panthsoni\xinlang\weibo\lib;

use panthsoni\xinlang\common\CommonValidate;

class SingleValidate extends CommonValidate
{
    protected $rule = [
        'client_id|客户端client_id' => 'length:0,20',
        'redirect_uri|回调地址redirect_uri' => 'length:0,255',
        'grant_type|类型grant_type' => 'length:0,50',
        'code|code' => 'length:0,50',
        'access_token|access_token' => 'length:0,50'
    ];

    public $scene = [
        'authorize' => ['client_id'=>'require|length:0,20','redirect_uri'=>'require|length:0,255'],
        'accessToken' => ['client_id'=>'require|length:0,20','redirect_uri'=>'require|length:0,255','grant_type'=>'require|length:0,50','code'=>'require|length:0,50'],
        'getTokenInfo' => ['access_token'=>'require|length:0,50'],
        'revokeOauth' => ['access_token'=>'require|length:0,50'],
    ];
}