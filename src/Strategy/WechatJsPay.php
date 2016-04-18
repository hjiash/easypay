<?php
namespace Eshow\Service\Pay\Platform;

use Omnipay\Omnipay;

use Eshow\Service\Pay\PaymentContext;
use Eshow\Service\Pay\PaymentStrategy;

class WechatJsPay extends WechatPay{
	public function __construct($body = null){
		$this->tradeType = 'JSAPI';
		
		parent::__construct($body);
	}

	protected function initGateWay(){
		parent::initGateway();

		$this->gateway->setOpenId($this->body->openid);
	}

	public function before(){

	}

	/**
	 * [doing description]
	 * @throws WechatPayRequestFailException
	 *         WechatPayRequestFailException
	 *         WechatPayRequestFailException
	 * @return [type] [description]
	 */
	public function doing(){
		parent::doing();

		$this->result = $this->result->createWebPaymentPackage();
	}

	public function after(){
		
	}
}
	
?>