<?php

namespace ChengFang\EasyPay\Exception;

class WechatPayException extends BaseException{

	public function __construct($message, $code = 0){
		parent::__construct($message, $code);
	}
}