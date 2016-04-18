<?php
namespace Eshow\Service\Pay\Platform;

use Omnipay\Omnipay;

use Eshow\Service\Pay\PaymentContext;
use Eshow\Service\Pay\PaymentStrategy;

class AlipayWapExpress extends Alipay{
	public function __construct($body = null){
		$this->tradeType = 'Alipay_WapExpress';
		
		parent::__construct($body);
	}

	protected function initGateway(){
		parent::initGateway();
	}

	public function before(){

	}

	public function doing(){
		parent::doing();
	}

	public function after(){

	}

}
?>