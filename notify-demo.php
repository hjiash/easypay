<?php

require __DIR__.'/vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use ChengFang\EasyPay\PaymentContext;

/**
 * 支付宝支付结果回调
 */
use \ChengFang\EasyPay\Traits\AlipayNotify;

$log = new Logger('alipay');
$log->pushHandler(new StreamHandler('logs/alipay.log', Logger::INFO));

$body = file_get_contents("php://input");
$log->addInfo('body', ['body' => $body]);

$context = new PaymentContext('Strategy\Alipay\AlipayNotify');
$context->execute($body);

try{
    $result = $context->getResult();
    /**
     * result是CompleteOrderResponse的对象
     * 可以根据微信支付文档，将参数转化成驼峰的形式获取返回值
     */
    $log->addInfo('result', [
        'trade_no' => $result->getRequest()->getRequestParams('trade_no'),
        'out_trade_no' => $result->getRequest()->getRequestParams('out_trade_no'),
    ]);
        
    $this->success();
}catch(Exception $e){
    $log->addInfo('exception', ['message' => $e->getMessage(), 'code' => $e->getCode()]);
    $this->fail();
}