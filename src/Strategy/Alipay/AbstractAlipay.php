<?php
namespace ChengFang\EasyPay\Strategy\Alipay;

use Omnipay\Omnipay;
use ChengFang\EasyPay\Configuration;
use ChengFang\EasyPay\Strategy\AbstractPayStrategy;


abstract class AbstractAlipay extends AbstractPayStrategy{

	public function __construct($body = null){
		parent::__construct($body);

		$this->platform = 'alipay';
		$this->keys = [
			'notify_url', 'return_url', 'out_trade_no', 
			'subject', 'body'
		];
	}

	protected function initGateway(){
		$this->gateway = Omnipay::create( $this->gatewayName ); 
        $this->gateway->setPartner( Configuration::get( 'alipay.id' ) );
        $this->gateway->setKey( Configuration::get( 'alipay.key' ) );
        $this->gateway->setSellerEmail( Configuration::get( 'alipay.email' ) );
        $this->gateway->setSellerId( Configuration::get( 'alipay.id' ) );
        $this->gateway->setNotifyUrl( $this->body['notify_url'] );
        $this->gateway->setReturnUrl( $this->body['return_url'] );
        $this->gateway->setSignType( 'MD5' );
	}

	public function doing(){
		$response = $this->gateway->purchase([
            'payment_type'  => '1',
            'out_trade_no'  => $this->body['out_trade_no'],
            'total_fee'     => $this->body['total_fee'],
            'subject'       => $this->body['subject'],
            'body'			=> $this->body['body']
        ])->send();

		$this->result = $response->getRedirectUrl();
	}
}