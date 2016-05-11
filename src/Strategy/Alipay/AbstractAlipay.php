<?php
namespace ChengFang\EasyPay\Strategy\Alipay;


use ChengFang\EasyPay\Configuration;
use ChengFang\EasyPay\Strategy\AbstractPayStrategy;


abstract class AbstractAlipay extends AbstractPayStrategy{

	public function __construct(){
		$this->platform = 'alipay';
		$this->keys = [
			'notify_url', 'return_url', 'out_trade_no', 
			'subject', 'body', 'total_fee'
		];
	}

	public function before(){
		$args = func_get_args();

		if(count($args) != 1 || !is_array($args[0])){
			throw new InvalidParamsException;
		}

		foreach ($this->keys as $key) {
			if(!array_key_exists($key, $args[0])){
				throw new InvalidParamsException;
			}
		}
	}

	public function doing(){
		$args = func_get_arg(0);

		$this->gateway->setPartner( Configuration::get( 'alipay.id' ) );
        $this->gateway->setKey( Configuration::get( 'alipay.key' ) );
        $this->gateway->setSellerEmail( Configuration::get( 'alipay.email' ) );
        $this->gateway->setSellerId( Configuration::get( 'alipay.id' ) );
        $this->gateway->setSignType( 'MD5' );

		$response = $this->gateway->purchase([
            'payment_type'  => '1',
            'notify_url'	=> $args['notify_url'],
            'return_url'	=> $args['return_url'],
            'out_trade_no'  => $args['out_trade_no'],
            'total_fee'     => $args['total_fee'],
            'subject'       => $args['subject'],
            'body'			=> $args['body']
        ])->send();

		$this->result = $response;
	}

	public function after(){

	}
}