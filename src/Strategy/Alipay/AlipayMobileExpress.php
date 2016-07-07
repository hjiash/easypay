<?php
namespace ChengFang\EasyPay\Strategy\Alipay;

use Omnipay\Omnipay;
use ChengFang\EasyPay\Configuration;

class AlipayMobileExpress extends AbstractAlipay{
	
	public function __construct(){
		parent::__construct();

		$this->platform = 'alipay_express';
		$this->gatewayName = 'Alipay_MobileExpress';

		$this->gateway = Omnipay::create( $this->gatewayName );
	}

	public function doing(){
		$args = func_get_arg(0);

		$this->gateway->setPartner( Configuration::get( 'alipay.id' ) );
        $this->gateway->setKey( Configuration::get( 'alipay.key' ) );
        $this->gateway->setSellerEmail( Configuration::get( 'alipay.email' ) );
        $this->gateway->setSellerId( Configuration::get( 'alipay.id' ) );
        $this->gateway->setSignType( 'RSA' );
        $this->gateway->setPrivateKey( Configuration::get('alipay.private_key') );

        $response = $this->gateway->purchase([
        	'payment_type'  => '1',
        	'out_trade_no'  => $args['out_trade_no'],
            'total_fee'     => $args['total_fee'],
            'subject'       => $args['subject'],
            'body'			=> $args['body'],
            'notify_url'	=> $args['notify_url'],
            'return_url'	=> $args['return_url']
        ])->send();

        $this->result = $response;
	}

}

?>