<?php
namespace ChengFang\EasyPay\Strategy\Alipay;


class AlipayPcExpress extends AbstractAlipay{
	
	public function __construct($body = null){
		parent::__construct($body);

		$this->platform = 'alipay_express';
		$this->gatewayName = 'Alipay_Express';
	}

	public function after(){}

}

?>