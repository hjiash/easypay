<?php
namespace ChengFang\EasyPay\Strategy\WechatPay;

use Omnipay\Omnipay;
use ChengFang\EasyPay\Configuration;
use ChengFang\EasyPay\Strategy\AbstractPayStrategy;

use Exception;
use ChengFang\EasyPay\Exception\WechatPayException;

class WechatPayNotify extends AbstractPayStrategy{
	public function __construct($body = null){
		parent::__construct($body);

		$this->platform = 'wechat';
		$this->gatewayName = 'WechatPay';
	}

	protected function initGateway(){
		$this->gateway = Omnipay::create( $this->gatewayName );
		$this->gateway->setKey( Configuration::get('wechat.pay_key') );
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
				throw new WechatPayException('通信失败');
			}
			if( !$response->isSignatureMatched() ){
				throw new WechatPayException( '签名校验失败' );
			}
			if( !$response->isResultSuccessful() ){
				throw new WechatPayException('业务结果失败');
			}

			$this->result = $response;
		}catch(Exception $e){
			throw new WechatPayException($e->getMessage());
		}
		
	}

	public function after(){

	}

	protected function validateBody(){
		if(empty($this->body) || !is_array($this->body)){
			throw new InvalidParamsException;
		}
	}
}
?>