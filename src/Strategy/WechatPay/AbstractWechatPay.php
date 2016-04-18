<?php
namespace ChengFang\EasyPay\Strategy\WechatPay;

use Omnipay\Omnipay;
use ChengFang\EasyPay\Configuration;
use ChengFang\EasyPay\Strategy\AbstractPayStrategy;

abstract class AbstractWechatPay extends AbstractPayStrategy{
	protected $tradeType;

	public function __construct($body = null){
		parent::__construct($body);
		
		$this->platform = 'wechat';
		$this->gatewayName = 'WechatPay';
		$this->keys = [
			'body', 'detail', 'out_trade_no',
			'total_fee', 'spbill_create_ip', 'notify_url'
		];
	}

	protected function initGateWay(){
		$this->gateway = Omnipay::create( $this->gatewayName );

		$this->gateway->setTradeType( $this->tradeType );

		$this->gateway->setAppId( Configuration::get('wechat.appid') );
		$this->gateway->setMchId( Configuration::get('wechat.mchid') );
		$this->gateway->setKey( Configuration::get('wechat.pay_key') );

		//$this->gateway->setProductId( $this->body->productId );
		$this->gateway->setBody( $this->body['body'] );
		$this->gateway->setDetail( $this->body['detail'] );
		$this->gateway->setOutTradeNo( $this->body['out_trade_no'] );
		$this->gateway->setTotalFee( round($this->body['total_fee']) );
		$this->gateway->setNotifyUrl( $this->body['notify_url'] );

		$this->gateway->setSpbillCreateIP( Request::ip() );
	}

	public function before(){
		$this->validateBody();
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