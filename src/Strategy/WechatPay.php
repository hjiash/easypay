<?php
namespace Eshow\Service\Pay\Platform;

use Config;

use Request;
use Omnipay\Omnipay;

use Eshow\Service\Pay\PaymentContext;
use Eshow\Service\Pay\PaymentStrategy;

class WechatPay extends PaymentStrategy{
	protected $tradeType;

	public function __construct($body = null){
		$this->platform = PaymentContext::$PAY_PLATFORM['wechat'];

		parent::__construct($body);
	}

	protected function initGateWay(){
		$this->gateway = Omnipay::create('WechatPay');

		$this->gateway->setTradeType( $this->tradeType );

		$this->gateway->setAppId( Config::get('payment.wechat.appid') );
		$this->gateway->setMchId( Config::get('payment.wechat.mchid') );
		$this->gateway->setKey( Config::get('payment.wechat.pay_key') );

		$this->gateway->setProductId( $this->body->productId );
		$this->gateway->setBody( $this->body->description );
		$this->gateway->setDetail( $this->body->detail );
		$this->gateway->setOutTradeNo( $this->body->orderNumber );
		$this->gateway->setTotalFee( round($this->body->totalFee * 100) );
		$this->gateway->setSpbillCreateIP( Request::ip() );
		$this->gateway->setNotifyUrl( $this->body->notifyUrl );
	}

	public function before(){

	}

	/**
	 * [doing description]
	 * @throws WechatPayRequestFailException
	 * @return [type] [description]
	 */
	public function doing(){
		$response = $this->gateway->createUnifiedOrder()->send();

		if( !$response->isResponseSuccessful() ){
			throw new \WechatPayRequestFailException( $response->getReturnMsg() );
		}
		if( !$response->isSignatureMatched() ){
			throw new \WechatPayRequestFailException( '签名校验失败，可能为非法响应' );
		}
		if( !$response->isResultSuccessful() ){
			throw new \WechatPayRequestFailException( $response->getErrCodeDes() );
		}

		$this->result = $response;
	}

	public function after(){

	}
}
	
?>