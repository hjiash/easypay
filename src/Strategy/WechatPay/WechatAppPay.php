<?php
namespace ChengFang\EasyPay\Strategy\WechatPay;

use ChengFang\EasyPay\Configuration;
use ChengFang\EasyPay\Exception\InvalidParamsException;

class WechatAppPay extends AbstractWechatPay{

	public function __construct(){
		parent::__construct();

		$this->platform = 'wechat_app_pay';
		$this->tradeType = 'APP';
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

		$this->gateway->setMchId( Configuration::get('wechat.mchid') );
		$this->gateway->setKey( Configuration::get('wechat.pay_key') );
		$this->gateway->setAppId(Configuration::get('wechat.app.appid'));
	}

	/**
	 * [doing description]
	 * @throws WechatPayRequestFailException
	 *         WechatPayRequestFailException
	 *         WechatPayRequestFailException
	 * @return [type] [description]
	 */
	public function doing(){
		$args = func_get_arg(0);
		parent::doing($args);
	}
}
	
?>