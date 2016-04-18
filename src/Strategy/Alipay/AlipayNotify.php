<?php
namespace ChengFang\EasyPay\Strategy\Alipay;

use Omnipay\Omnipay;
use ChengFang\EasyPay\Configuration;
use ChengFang\EasyPay\Strategy\AbstractPayStrategy;

use Exception;
use ChengFang\EasyPay\Exception\AlipayException;


class AlipayNotify extends AbstractPayStrategy{

	public function __construct($body = null){
		parent::__construct($body);

		$this->platform = 'alipay';
		$this->gatewayName = 'Alipay_Express';
	}

	protected function initGateway(){
		$this->gateway = Omnipay::create( $this->gatewayName );
        $this->gateway->setPartner( Configuration::get( 'alipay.id' ) );
        $this->gateway->setKey( Configuration::get( 'alipay.key' ) );
        $this->gateway->setSellerEmail( Configuration::get( 'alipay.email' ) );
	}

	/**
	 * [doing description]
	 * @throws AlipayNoticeException
	 *         AlipayRequestFailException
	 * @return [type] [description]
	 */
	public function doing(){
		
		try{
			$response = $this->gateway->completePurchase([
	            'request_params' => $this->body,
	        ])->send();

	        if(!$response->isSuccessful()){
	        	throw new AlipayException('签名校验失败');
	        }
	        if(!$response->isPaid()){
	        	throw new AlipayException('支付失败');
			}

	        $this->result = $response;
		}catch(Exception $e){
			throw new  AlipayException($e->getMessage());;
		}
		
	}

	public function after(){

	}

	protected function validateBody(){
		if(empty($this->body) || !is_array($this->body)){
			throw new InvalidParamsException;
		}
	}
}
?>