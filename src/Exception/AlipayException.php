<?php

namespace ChengFang\EasyPay\Exception;

class AlipayException extends BaseException{

	public function __construct($message, $code = 0){
		parent::__construct($message, $code);
	}
}