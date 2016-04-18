<?php
namespace Eshow\Service\Pay\Platform;

use Config;

use Omnipay\Omnipay;

use Eshow\Service\Pay\PaymentContext;
use Eshow\Service\Pay\PaymentStrategy;

class Alipay extends PaymentStrategy{
	protected $tradeType;

	public function __construct($body = null){
		$this->platform = PaymentContext::$PAY_PLATFORM['alipay'];

		parent::__construct($body);
	}

	protected function initGateway(){
		$this->gateway = Omnipay::create( $this->tradeType ); 
        $this->gateway->setPartner( Config::get( 'payment.alipay.id' ) );
        $this->gateway->setKey( Config::get( 'payment.alipay.key' ) );
        $this->gateway->setSellerEmail( Config::get( 'payment.alipay.email' ) );
        $this->gateway->setSellerId( Config::get( 'payment.alipay.id' ) );
        $this->gateway->setNotifyUrl( $this->body->notifyUrl );
        $this->gateway->setReturnUrl( $this->body->returnUrl );
        $this->gateway->setSignType( 'MD5' );
	}

	public function before(){

	}

	public function doing(){
		$response = $this->gateway->purchase([
            'payment_type'  => '1',
            'out_trade_no'  => $this->body->orderNumber,
            'total_fee'     => $this->body->totalFee,
            'subject'       => $this->body->description,
            'body'			=> $this->body->detail
        ])->send();

		$this->result = $response->getRedirectUrl();
	}

	public function after(){

	}
}