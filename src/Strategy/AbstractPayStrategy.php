<?php
namespace ChengFang\EasyPay\Strategy;

use ChengFang\EasyPay\Exception\InvalidParamsException;

abstract class AbstractPayStrategy{
	protected $body;

	protected $platform;
	protected $gateway;
	protected $gatewayName;
	protected $keys;
	protected $result;

	public function __construct($body = null){
		if(!is_null($body)){
			$this->body = $body;
		}
	}

	public function before(){
		$this->validateBody();	
	}
	abstract protected function initGateway();
	abstract public function doing();
	abstract public function after();

	public function execute(){
		$this->before();

		$this->initGateway();

		$this->doing();
		$this->after();
	}

	public function setBody($body){
		$this->body = $body;
	}

	public function getBody(){
		return $this->body;
	}

	public function getResult(){
		return $this->result;
	}

	public function getPlatform(){
		return $this->platform;
	}

	public function getKeys(){
		return $this->keys;
	}

	protected function validateBody(){
		if(empty($this->body) || !is_array($this->body)){
			throw new InvalidParamsException;
		}

		foreach($this->keys as $key){
			if(!array_key_exists($key, $this->body)){
				throw new InvalidParamsException;
			}
		}
	}
}
?>