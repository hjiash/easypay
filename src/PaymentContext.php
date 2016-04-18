<?php
namespace ChengFang\EasyPay;

class PaymentContext{

	private $strategy;

	public function __construct(PaymentStrategy $strategy = null){
		if(!is_null($strategy)){
			$this->strategy = $strategy;
		}
	}

	public function execute(){
		$this->strategy->execute();
	}

	public function setStrategy(PaymentStrategy $strategy){
		$this->strategy = $strategy;
	}

	public function getStrategy(){
		return $this->strategy;
	}

	public function getResult(){
		return $this->strategy->getResult();
	}
}
?>