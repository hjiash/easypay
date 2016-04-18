<?php
namespace Eshow\Service\Pay\Platform;

use Config;

use Omnipay\Omnipay;

use Eshow\Service\Pay\PaymentContext;
use Eshow\Service\Pay\PaymentStrategy;

class AlipayNotify extends PaymentStrategy{
	public function __construct($body = null){
		$this->platform = PaymentContext::$PAY_PLATFORM['alipay'];
		
		if(!is_null($body)){
			$this->body = $body;
		}
	}

	protected function initGateway(){
		$this->gateway = Omnipay::create( 'Alipay_Express' );
        $this->gateway->setPartner( Config::get( 'payment.alipay.id' ) );
        $this->gateway->setKey( Config::get( 'payment.alipay.key' ) );
        $this->gateway->setSellerEmail( Config::get( 'payment.alipay.email' ) );
	}

	public function before(){

	}

	/**
	 * [doing description]
	 * @throws AlipayNoticeException
	 *         AlipayRequestFailException
	 * @return [type] [description]
	 */
	public function doing(){
		try{
			$response = $this->gateway->completePurchase([
	            'request_params' => $this->body,
	        ])->send();

	        if(!$response->isSuccessful()){
	        	throw new \AlipayNoticeException();
	        }
	        if(!$response->isPaid()){
	        	throw new \AlipayRequestFailException();
			}

	        $this->result = $response;
		}catch(\Exception $e){
			throw new \AlipayNoticeException($e->getMessage());
		}
		
	}

	public function after(){

	}
}
?>