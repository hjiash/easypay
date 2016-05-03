<?php
namespace ChengFang\EasyPay\Strategy;

use ChengFang\EasyPay\Exception\InvalidParamsException;

abstract class AbstractPayStrategy{
	protected $platform;
	protected $gateway;
	protected $gatewayName;
	protected $keys;
	protected $result;

	abstract public function before();
	abstract public function doing();
	abstract public function after();

	public function execute(){
		// $this->before($args);
		// $this->doing($args);
		// $this->after();
		$args = func_get_args();

		call_user_func_array([$this, 'before'], $args);
		call_user_func_array([$this, 'doing'], $args);
		call_user_func_array([$this, 'after'], []);
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
}
?>