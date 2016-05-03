<?php
namespace ChengFang\EasyPay\Strategy\WechatPay;

class WechatUnifiedPay extends AbstractWechatPay{
	public function __construct(){
		parent::__construct();

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
		$args = func_get_arg(0);

		$this->gateway->setProductId($args['product_id']);
		parent::doing($args);
		
		$this->result = $this->result->getCodeUrl();
	}

}
?>