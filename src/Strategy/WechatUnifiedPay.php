<?php
namespace Eshow\Service\Pay\Platform;

use Omnipay\Omnipay;

use Eshow\Service\Pay\PaymentContext;
use Eshow\Service\Pay\PaymentStrategy;

class WechatUnifiedPay extends WechatPay{
	public function __construct($body = null){
		$this->tradeType = 'NATIVE';

		parent::__construct($body);
	}

	public function before(){

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

		// $result = [
		// 	'appid' => $this->result->getAppId(),
		// 	'prepay_id' => $this->result->getPrepayId(),
		// 	'nonce_str' => $this->result->getNonceStr(),
		// 	'sign' => $this->result->getSign(),
		// 	'timestamp' => time(),
		// ];
		// $this->result = $result;
		$this->result = $this->result->getCodeUrl();
	}

	public function after(){

	}
}
?>