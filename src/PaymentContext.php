<?php
namespace ChengFang\EasyPay;

use ChengFang\EasyPay\Strategy\AbstractPayStrategy;

class PaymentContext{

	private $strategy;

	public function __construct($stragety){
		$class = __NAMESPACE__.'\\'.$stragety;

		$this->strategy = new $class();
	}

	public function execute(){
		$args = func_get_args();

		call_user_func_array([$this->strategy, 'execute'], $args);
	}

	public function setStrategy(AbstractPayStrategy $strategy){
		$this->strategy = $strategy;
	}

	public function getStrategy(){
		return $this->strategy;
	}

	public function getResult(){
		return $this->strategy->getResult();
	}

	public function getKeys(){
		return $this->stragety->getKeys();
	}

	public function getPlatform(){
		return $this->stragety->getPlatform();
	}

	public function success(){
		$message = func_get_arg(0);

		return $this->strategy->success();
	}

	public function fail(){
		return $this->strategy->fail();
	}
}
?>