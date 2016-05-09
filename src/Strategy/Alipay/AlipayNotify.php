<?php
namespace ChengFang\EasyPay\Strategy\Alipay;

use Omnipay\Omnipay;
use ChengFang\EasyPay\Configuration;
use ChengFang\EasyPay\Strategy\AbstractPayStrategy;

use Exception;
use ChengFang\EasyPay\Exception\InvalidParamsException;
use ChengFang\EasyPay\Exception\AlipayException;


class AlipayNotify extends AbstractPayStrategy{

	public function __construct(){
		$this->platform = 'alipay';
		$this->gatewayName = 'Alipay_Express';

		$this->gateway = Omnipay::create( $this->gatewayName );
	}

	public function before(){
		if(func_num_args() != 1){
			throw new InvalidParamsException;
		}
	}

	/**
	 * [doing description]
	 * @throws AlipayNoticeException
	 *         AlipayRequestFailException
	 * @return [type] [description]
	 */
	public function doing(){
		$body = func_get_arg(0);

		try{
			$this->gateway->setPartner( Configuration::get( 'alipay.id' ) );
        	$this->gateway->setKey( Configuration::get( 'alipay.key' ) );
        	$this->gateway->setSellerEmail( Configuration::get( 'alipay.email' ) );

			$response = $this->gateway->completePurchase([
	            'request_params' => $body,
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

	public function success(){
		return $this->createResponse(true);
	}

	public function fail(){
		return $this->createResponse(false);
	}

	protected function createResponse($success = true){
		return $success? 'success' : 'fail';
	}
}
?>