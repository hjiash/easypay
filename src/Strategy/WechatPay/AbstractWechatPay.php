<?php
namespace ChengFang\EasyPay\Strategy\WechatPay;

use ChengFang\EasyPay\Exception\InvalidParamsException;
use ChengFang\EasyPay\Exception\WechatPayException;

use Omnipay\Omnipay;
use ChengFang\EasyPay\Configuration;
use ChengFang\EasyPay\Strategy\AbstractPayStrategy;

abstract class AbstractWechatPay extends AbstractPayStrategy{
	protected $tradeType;

	public function __construct(){
		$this->platform = 'wechat';
		$this->gatewayName = 'WechatPay';
		$this->keys = [
			'body', 'detail', 'out_trade_no',
			'total_fee', 'spbill_create_ip', 'notify_url'
		];

		$this->gateway = Omnipay::create( $this->gatewayName );
	}

	public function before(){
		$args = func_get_args();

		if(count($args) != 1 || !is_array($args[0])){
			throw new InvalidParamsException;
		}

		foreach ($this->keys as $key) {
			if(!array_key_exists($key, $args[0])){
				throw new InvalidParamsException;
			}
		}

		$this->gateway->setAppId( Configuration::get('wechat.appid') );
		$this->gateway->setMchId( Configuration::get('wechat.mchid') );
		$this->gateway->setKey( Configuration::get('wechat.pay_key') );
	}

	/**
	 * [doing description]
	 * @throws WechatPayException
	 * @return [type] [description]
	 */
	public function doing(){

		$args = func_get_arg(0);

		$this->gateway->setTradeType( $this->tradeType );
		$this->gateway->setBody( $args['body'] );
		$this->gateway->setDetail( $args['detail'] );
		$this->gateway->setOutTradeNo( $args['out_trade_no'] );
		$this->gateway->setTotalFee( round($args['total_fee']) );
		$this->gateway->setNotifyUrl( $args['notify_url'] );
		$this->gateway->setSpbillCreateIP( $args['spbill_create_ip'] );

		$response = $this->gateway->createUnifiedOrder()->send();

		if( !$response->isResponseSuccessful() ){
			throw new WechatPayException( $response->getReturnMsg() );
		}
		if( !$response->isSignatureMatched() ){
			throw new WechatPayException( '签名校验失败，可能为非法响应' );
		}
		if( !$response->isResultSuccessful() ){
			throw new WechatPayException( $response->getErrCodeDes() );
		}

		$this->result = $response;
	}

	public function after(){

	}
}
	
?>