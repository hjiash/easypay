<?php
namespace ChengFang\EasyPay\Strategy\WechatPay;

use Omnipay\Omnipay;
use ChengFang\EasyPay\Configuration;
use ChengFang\EasyPay\Strategy\AbstractPayStrategy;

use Exception;
use ChengFang\EasyPay\Exception\InvalidParamsException;
use ChengFang\EasyPay\Exception\WechatPayException;

class WechatPayNotify extends AbstractPayStrategy{
	use \Omnipay\WechatPay\Traits\XMLTrait;

	public function __construct(){
		$this->platform = 'wechat';
		$this->gatewayName = 'WechatPay';

		$this->gateway = Omnipay::create( $this->gatewayName );
	}

	public function before(){
		if(func_num_args() != 1){
			throw new InvalidParamsException;
		}

		$this->gateway->setKey( Configuration::get('wechat.pay_key') );
	}

	/**
	 * [doing description]
	 * @throws WechatPayNoticeException
	 * @return [type] [description]
	 */
	public function doing(){
		$body = func_get_arg(0);

		try{
			$response = $this->gateway->completeOrder( $body )->send();

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
}
?>