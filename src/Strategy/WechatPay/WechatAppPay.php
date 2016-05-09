<?php
namespace ChengFang\EasyPay\Strategy\WechatPay;

class WechatAppPay extends AbstractWechatPay{

	public function __construct(){
		parent::__construct();

		$this->platform = 'wechat_js_pay';
		$this->tradeType = 'APP';
	}

	public function before(){
		parent::before();

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

		$this->gateway->setOpenId($args['openid']);

		parent::doing($args);
	}
}
	
?>