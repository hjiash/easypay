<?php
namespace ChengFang\EasyPay\Strategy\Alipay;

use Omnipay\Omnipay;

class AlipayWapExpress extends AbstractAlipay{
	
	public function __construct($body = null){
		parent::__construct($body);

		$this->platform = 'alipay_wap_express';
		$this->gatewayName = 'Alipay_WapExpress';

		$this->gateway = Omnipay::create( $this->gatewayName );
	}
}