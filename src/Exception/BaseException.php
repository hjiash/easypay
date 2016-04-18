<?php
namespace ChengFang\EasyPay\Exception;

class BaseException extends Exception implements JsonSerializable{
	
	public function jsonSerialize(){
		return formatResponse($this->getCode(), $this->getMessage());
	}
	
} 