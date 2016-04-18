<?php
namespace Eshow\Service\Pay\Platform;

class WechatUnifiedPay extends WechatPay{
	public function __construct($body = null){
		parent::__construct($body);

		$this->platform = 'wechat_unified_pay';
		$this->tradeType = 'NATIVE';

		array_push($this->keys, 'product_id');
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
		
		$this->result = $this->result->getCodeUrl();
	}

	public function after(){

	}
}
?>