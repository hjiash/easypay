<?php
namespace ChengFang\EasyPay\Strategy\WechatPay;

class WechatJsPay extends AbstractWechatPay{

	public function __construct(){
		parent::__construct();

		$this->platform = 'wechat_js_pay';
		$this->tradeType = 'JSAPI';

		array_push($this->keys, 'openid');
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

		// $this->result = $this->result->createWebPaymentPackage();
	}
}
	
?>