<?php
namespace Eshow\Service\Pay\Platform;

class WechatJsPay extends AbstractWechatPay{

	public function __construct($body = null){
		parent::__construct($body);

		$this->platform = 'wechat_js_pay';
		$this->tradeType = 'JSAPI';

		array_push($this->keys, 'openid');
	}

	protected function initGateWay(){
		parent::initGateway();
		$this->gateway->setOpenId($this->body['openid']);
	}

	/**
	 * [doing description]
	 * @throws WechatPayRequestFailException
	 *         WechatPayRequestFailException
	 *         WechatPayRequestFailException
	 * @return [type] [description]
	 */
	public function doing(){
		parent::doing();

		$this->result = $this->result->createWebPaymentPackage();
	}

	public function after(){
		
	}
}
	
?>