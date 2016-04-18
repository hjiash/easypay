<?php
namespace Eshow\Service\Pay\Platform;

use Config;

use Omnipay\Omnipay;

use Eshow\Service\Pay\PaymentContext;
use Eshow\Service\Pay\PaymentStrategy;

class WechatPayNotify extends PaymentStrategy{
	public function __construct($body = null){
		$this->platform = PaymentContext::$PAY_PLATFORM['wechat'];
		
		if(!is_null($body)){
			$this->body = $body;
		}
	}

	protected function initGateway(){
		$this->gateway = Omnipay::create('WechatPay');
		$this->gateway->setKey( Config::get('payment.wechat.pay_key') );
	}

	public function before(){

	}

	/**
	 * [doing description]
	 * @throws WechatPayNoticeException
	 * @return [type] [description]
	 */
	public function doing(){
		try{
			$response = $this->gateway->completeOrder( $this->body )->send();

			if( !$response->isResponseSuccessful() ){
				throw new \WechatPayNoticeException($response->getReturnMsg());
			}
			if( !$response->isSignatureMatched() ){
				throw new \WechatPayNoticeException( '签名校验失败，可能为非法响应' );
			}
			if( !$response->isResultSuccessful() ){
				throw new \WechatPayNoticeException($response->getErrCodeDes());
			}

			$this->result = $response;
		}catch(\Exception $e){
			throw new \WechatPayNoticeException($e->getMessage());
		}
		
	}

	public function after(){

	}
}
?>