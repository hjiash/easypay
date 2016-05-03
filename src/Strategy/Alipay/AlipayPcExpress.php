<?php
namespace ChengFang\EasyPay\Strategy\Alipay;

use Omnipay\Omnipay;

class AlipayPcExpress extends AbstractAlipay{
	
	public function __construct(){
		parent::__construct();

		$this->platform = 'alipay_express';
		$this->gatewayName = 'Alipay_Express';

		$this->gateway = Omnipay::create( $this->gatewayName );
	}

}

?>