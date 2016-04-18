<?php
namespace Eshow\Service\Pay;

abstract class PaymentStrategy{
	protected $platform;
	protected $gateway;
	protected $body;
	protected $result;

	public function __construct($body = null){
		if(!is_null($body)){
			$this->body = $body;
		}
	}

	abstract protected function initGateway();
	abstract public function before();
	abstract public function doing();
	abstract public function after();
	public function execute(){
		$this->initGateway();
		$this->before();
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
}
?>