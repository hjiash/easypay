<?php

require __DIR__.'/vendor/autoload.php';

use ChengFang\EasyPay\PaymentContext;

date_default_timezone_set('UTC');

function createOrderNumber(){
	$orderNumber = date('YmdHis').substr(microtime(), 2, 6);
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
// echo $context->getResult();

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
// echo $context->getResult();

/**
 * 支付宝PC即时到账
 * @var [type]
 */
$order = [
	'subject' => '商品描述',
	'body' => '商品详情',
	'out_trade_no' => createOrderNumber(),
	'total_fee' => 0.01,
	'notify_url' => '',
	'return_url' => ''
];
// $context = new PaymentContext('Strategy\Alipay\AlipayPcExpress');
// $context->execute($order);
// echo $context->getResult();

/**
 * 支付宝手机即时到账
 * @var [type]
 */
$context = new PaymentContext('Strategy\Alipay\AlipayWapExpress');
$context->execute($order);
echo $context->getResult();