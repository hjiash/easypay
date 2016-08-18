<?php

require __DIR__.'/vendor/autoload.php';

use ChengFang\EasyPay\PaymentContext;

/**
 * 支付宝支付结果回调
 */
use \ChengFang\EasyPay\Traits\AlipayNotify;

$body = [
    "discount" => "0.00",
    "payment_type" => "1",
    "subject" => "国枫服务",
    "trade_no" => "2016070821001004790257969793",
    "buyer_email" => "qjaviavi@126.com",
    "gmt_create" => "2016-07-08 18:29:19",
    "notify_type" => "trade_status_sync",
    "quantity" => "1",
    "out_trade_no" => "201607081636018187",
    "seller_id" => "2088421354060067",
    "notify_time" => "2016-07-08 18:29:20",
    "body" => "国枫服务",
    "trade_status" => "TRADE_SUCCESS",
    "is_total_fee_adjust" => "N",
    "total_fee" => "0.01",
    "gmt_payment" => "2016-07-08 18:29:20",
    "seller_email" => "jiakao@zerioi.com",
    "price" => "0.01",
    "buyer_id" => "2088502781002797",
    "notify_id" => "449075188c6291ee85e53e82d185fb2m3i",
    "use_coupon" => "N",
    "sign_type" => "RSA",
    "sign" => "Ss0Y3LZKoN9TTTMe094KeMOOMQQlQ/8/SfVseKqL9VngjLybkxBQ/TFwgPTgUfw4y3CMxtbtOi1CO/BHJ6IFB4WLPEQFYJYSDNEflDVwGKdvyP/u+pa4YkmJReSUXA0b3zvdaK/EjcTQWpQP9pNcreWcYF7wXH5lSui18UD6854="
];

$context = new PaymentContext('Strategy\Alipay\AlipayNotify');

$context->execute($body);
$result = $context->getResult();
/**
 * result是CompleteOrderResponse的对象
 * 可以根据微信支付文档，将参数转化成驼峰的形式获取返回值
 */
echo json_encode([
    'trade_no' => $result->getRequest()->getRequestParam('trade_no'),
    'out_trade_no' => $result->getRequest()->getRequestParam('out_trade_no'),
]);
