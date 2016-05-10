### 1. 说明

使用前，请进入src/目录下，复制Configuration.php.example并重命名为Configuration.php，配置好参数。


所有属性值支持以下方式进行set/get:
```php
$this->setParameter('key', $value);
$this->getParameter('key');
```

另外，微信支付支持将参数名转换成大驼峰，前面加get/set的方法名获取，如 
```php
$request->getOutTradeNo();
$request->setOutTradeNo();
```

### 以下是demo

> 微信扫码支付

```php
$order = [
	'body' => '商品描述',
	'detail' => '商品详情',
	'out_trade_no' => createOrderNumber(),
	'product_id' => 1,
	'total_fee' => 1,
	'spbill_create_ip' => getClientIp(),
	'notify_url' => 'http://test.com',
];
$context = new PaymentContext('Strategy\WechatPay\WechatUnifiedPay');
$context->execute($order);
$result = $context->getResult();
$result->getCodeUrl();
```

> 微信公众号内支付

```php
$order = [
	'body' => '商品描述',
	'detail' => '商品详情',
	'out_trade_no' => createOrderNumber(),
	'total_fee' => 1,
	'spbill_create_ip' => getClientIp(),
	'notify_url' => 'http://test.com',
	'openid' => 'openid'
];
$context = new PaymentContext('Strategy\WechatPay\WechatJsPay');
$context->execute($order);
$result = $context->getResult();
$result->createWebPaymentPackage();
```

> 微信APP支付

```php
$order = [
 'body' => '商品描述',
 'detail' => '商品详情',
 'out_trade_no' => createOrderNumber(),
 'total_fee' => 1,
 'spbill_create_ip' => getClientIp(),
 'notify_url' => 'http://test.com',
 'openid' => 'openid'
];
$context = new PaymentContext('Strategy\WechatPay\WechatAppPay');
$context->execute($order);
$result = $context->getResult();
```

> 微信支付结果回调

```php
$body = file_get_contents('php://input');
$context = new PaymentContext('Strategy\WechatPay\WechatPayNotify');
$context->execute($body);

try{
    $result = $context->getResult();
    /**
     * result是CompleteOrderResponse的对象
     * 可以根据微信支付文档，将参数转化成驼峰的形式获取返回值
    */
    
    // $result->getTransactionId();
    // $result->getOutTradeNo();
    
    // self::success($message = null);
    self::success('信息可以不需要');
}catch(Exception $e){
    // self::fail($message = null);
    self::fail('信息可以不需要');
}
```

> 微信红包

```php
$redPack = [
    'send_name' => '广州乘方',
    're_openid' => 'o6FwguKysTyj3zlikp8U8DwHk4XA',
    'total_amount' => 100,
    'total_num' => 1,
    'wishing' => '祝福语',
    'client_ip' => getClientIp(),
    'act_name' => '活动名称',
    'remark' => '备注'
];
$context = new PaymentContext('Strategy\WechatPay\WechatRedPack');
$context->execute($redPack);
$result = $context->getResult();
echo $result->getSendListid();
```

> 支付宝PC即时到账

```php
$order = [
	'subject' => '商品描述',
	'body' => '商品详情',
	'out_trade_no' => createOrderNumber(),
	'total_fee' => 0.01,
	'notify_url' => '',
	'return_url' => ''
];
$context = new PaymentContext('Strategy\Alipay\AlipayPcExpress');
$context->execute($order);
echo $context->getResult()->getRedirectUrl();
```

> 支付宝手机即时到账

```php
$order = [
	'subject' => '商品描述',
	'body' => '商品详情',
	'out_trade_no' => createOrderNumber(),
	'total_fee' => 0.01,
	'notify_url' => '',
	'return_url' => ''
];
$context = new PaymentContext('Strategy\Alipay\AlipayWapExpress');
$context->execute($order);
echo $context->getResult()->getRedirectUrl();
```


> 支付宝支付结果回调

```php
$body = Input::get();
$context = new PaymentContext('Strategy\WechatPay\WechatPayNotify');
$context->execute($body);

try{
    $result = $context->getResult();
    
    // $result->getRequest()->getParameter('trade_no');
    // $result->getRequest()->getParameter('out_trade_no');
        
    self::success();
}catch(Exception $e){
    self::fail();
}
```
