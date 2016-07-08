<?php

require __DIR__.'/vendor/autoload.php';

use ChengFang\EasyPay\PaymentContext;

/**
 * 支付宝支付结果回调
 */
use \ChengFang\EasyPay\Traits\AlipayNotify;

$body = [
    'discount' => "0.00",
    'payment_type' => "1",
    'subject' => '国枫服务',
    "trade_no" => "2016070821001004510255999566",
    "buyer_email" => "hjiasheng@gmail.com",
    "gmt_create" => "2016-07-08 15:25:22",
    "notify_type" => "trade_status_sync",
    "quantity" => "1",
    "out_trade_no" => "201607081525132612",
    "seller_id" => "2088421354060067",
    "notify_time" => "2016-07-08 15:25:22",
    "body" => "国枫服务",
    "trade_status" => "TRADE_SUCCESS",
    "is_total_fee_adjust" => "N",
    "total_fee" => "0.01",
    "gmt_payment" => "2016-07-08 15:25:22",
    "seller_email" => "jiakao@zerioi.com",
    "price" => "0.01",
    "buyer_id" => "2088502698118514",
    "notify_id" => "21e13942638d28221ef16a59f932292jxq",
    "use_coupon" => "N",
    "sign_type" => "RSA",
    "sign" => "LfAzL5nNDxcCn0d5vwZc3NDer9KTabGddFbPcr6Jq7dWnQ9TgvddkX4rZasPOr7Bw5xg+XOifHu5+HCe8aH88PtMcLR8ZTkxZpWGOwaijoWuSgfbOJOR5Nog3sXv550sEuxwUgwh1FqlCTenp5yUUjnu4FRu+OOXxhTWUW+Xsqw="
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
