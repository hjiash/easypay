<?php

require __DIR__.'/vendor/autoload.php';

use ChengFang\EasyPay\PaymentContext;
use ChengFang\EasyPay\Configuration;

date_default_timezone_set('UTC');

function createOrderNumber(){
	$orderNumber = date('YmdHis').substr(microtime(), 2, 4);
	return $orderNumber;
}

function getClientIp() { 
    if(getenv('HTTP_CLIENT_IP')){ 
        $ip = getenv('HTTP_CLIENT_IP'); 
    } elseif(getenv('HTTP_X_FORWARDED_FOR')) { 
        $ip = getenv('HTTP_X_FORWARDED_FOR'); 
    } elseif(getenv('REMOTE_ADDR')) {
        $ip = getenv('REMOTE_ADDR'); 
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    } 
    return $ip; 
}

/**
 * 微信扫码支付
 * @var [type]
 */
// $order = [
// 	'body' => '商品描述',
// 	'detail' => '商品详情',
// 	'out_trade_no' => createOrderNumber(),
// 	'product_id' => 1,
// 	'total_fee' => 1,
// 	'spbill_create_ip' => getClientIp(),
// 	'notify_url' => 'http://test.com',
// ];
// $context = new PaymentContext('Strategy\WechatPay\WechatUnifiedPay');
// $context->execute($order);
// $result = $context->getResult();
// $result->getCodeUrl();

/**
 * 微信公众号内支付
 * @var [type]
 */
// $order = [
// 	'body' => '商品描述',
// 	'detail' => '商品详情',
// 	'out_trade_no' => createOrderNumber(),
// 	'total_fee' => 1,
// 	'spbill_create_ip' => getClientIp(),
// 	'notify_url' => 'http://test.com',
// 	'openid' => 'openid'
// ];
// $context = new PaymentContext('Strategy\WechatPay\WechatJsPay');
// $context->execute($order);
// $result = $context->getResult();
// $result->createWebPaymentPackage();

/**
 * 微信APP支付
 * @var [type]
 */
// $order = [
//  'body' => '商品描述',
//  'detail' => '商品详情',
//  'out_trade_no' => createOrderNumber(),
//  'total_fee' => 1,
//  'spbill_create_ip' => getClientIp(),
//  'notify_url' => 'http://test.com',
//  'openid' => 'openid'
// ];
// $context = new PaymentContext('Strategy\WechatPay\WechatAppPay');
// $context->execute($order);
// $result = $context->getResult();


/**
 * 微信支付结果回调
 */
// use \ChengFang\EasyPay\Traits\WechatPayNotify;

// $body = file_get_contents('php://input');
// $context = new PaymentContext('Strategy\WechatPay\WechatPayNotify');
// $context->execute($body);

// try{
//     $result = $context->getResult();
//     *
//      * result是CompleteOrderResponse的对象
//      * 可以根据微信支付文档，将参数转化成驼峰的形式获取返回值
     
    
//     // $result->getTransactionId();
//     // $result->getOutTradeNo();
    
//     // $this->success($message = null);
//     $this->success('信息可以不需要');
// }catch(Exception $e){
//     // $this->fail($message = null);
//     $this->fail('信息可以不需要');
// }

/**
 * 微信红包
 */
// $redPack = [
//     'send_name' => '广州乘方',
//     're_openid' => 'o6FwguKysTyj3zlikp8U8DwHk4XA',
//     'total_amount' => 100,
//     'total_num' => 1,
//     'wishing' => '祝福语',
//     'client_ip' => getClientIp(),
//     'act_name' => '活动名称',
//     'remark' => '备注'
// ];
// $context = new PaymentContext('Strategy\WechatPay\WechatRedPack');
// $context->execute($redPack);
// /**
//  * result是RedPackResponse的对象
//  * 可以根据微信支付文档，将参数转化成驼峰的形式获取返回值
//  */
// $result = $context->getResult();
// echo $result->getSendListid();
// exit;

/**
 * 支付宝PC即时到账
 * @var [type]
 */
// $order = [
//     'notify_url' => 'http://baidu.com',
//     'return_url' => 'http://baidu.com',
// 	'subject' => '商品描述',
// 	'body' => '商品详情',
// 	'out_trade_no' => createOrderNumber(),
// 	'total_fee' => 0.01
// ];
// $context = new PaymentContext('Strategy\Alipay\AlipayPcExpress');
// $context->execute($order);
// $result = $context->getResult();
// echo $result->getRedirectUrl();
// exit;

/**
 * 支付宝移动支付
 * @var [type]
 */
$order = [
    'notify_url' => 'http://www.zerioi.com',
    'return_url' => 'http://www.zerioi.com',
    'subject' => '商品描述',
    'body' => '商品详情',
    'out_trade_no' => createOrderNumber(),
    'total_fee' => 0.01
];
$context = new PaymentContext('Strategy\Alipay\AlipayMobileExpress');
$context->execute($order);
$result = $context->getResult();
echo base64_encode($result->getOrderString());
exit;

/**
 * 支付宝手机即时到账
 * @var [type]
 */
// $context = new PaymentContext('Strategy\Alipay\AlipayWapExpress');
// $context->execute($order);
// $result = $context->getResult();
// echo $result->getRedirectUrl();
// exit;

/**
 * 支付宝支付结果回调
 */
use \ChengFang\EasyPay\Traits\AlipayNotify;

$body = Input::get();
$context = new PaymentContext('Strategy\WechatPay\WechatPayNotify');
$context->execute($body);

try{
    $result = $context->getResult();
    /**
     * result是CompleteOrderResponse的对象
     * 可以根据微信支付文档，将参数转化成驼峰的形式获取返回值
     */
    
    // $result->getRequest()->getRequestParams('trade_no');
    // $result->getRequest()->getRequestParams('out_trade_no');
        
    $this->success();
}catch(Exception $e){
    $this->fail();
}