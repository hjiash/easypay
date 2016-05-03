<?php
namespace ChengFang\EasyPay\Exception;

use JsonSerializable;
use Exception;

class BaseException extends Exception implements JsonSerializable{
	
	public function jsonSerialize(){
		return [
			'errCode' => $this->getCode(),
			'message' => $this->getMessage()
		];
	}
	
} 