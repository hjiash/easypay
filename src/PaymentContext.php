<?php
namespace Eshow\Service\Pay;

class PaymentContext{
	public static $PAY_PLATFORM = [
		'wechat' => '1',
		'alipay' => '2',
		'direct' => '3',
	];

	const WECHAT_PAY = '1';
	const ALIPAY = '2';
	const DIRECT_PAY = '3';

	public static $PAY_PLATFORM_ALIAS = [
		self::WECHAT_PAY => '微信支付',
		self::ALIPAY => '支付宝支付',
		self::DIRECT_PAY => '平台内支付（未使用第三方支付）',
	];

	private $strategy;

	public function __construct(PaymentStrategy $strategy = null){
		if(!is_null($strategy)){
			$this->strategy = $strategy;
		}
	}

	public function execute(){
		$this->strategy->execute();
	}

	public function setStrategy(PaymentStrategy $strategy){
		$this->strategy = $strategy;
	}

	public function getStrategy(){
		return $this->strategy;
	}
}
?>