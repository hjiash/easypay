<?php
namespace ChengFang\EasyPay\Strategy\WechatPay;

use ChengFang\EasyPay\Exception\InvalidParamsException;
use ChengFang\EasyPay\Exception\WechatPayException;

use Omnipay\Omnipay;
use ChengFang\EasyPay\Configuration;
use ChengFang\EasyPay\Strategy\AbstractPayStrategy;

class WechatRedPack extends AbstractPayStrategy{

	public function __construct(){
		$this->platform = 'wechat';
		$this->gatewayName = 'WechatPay';
		$this->keys = [
            'send_name',
            're_openid',
            'total_amount',
            'total_num',
            'wishing',
            'client_ip',
            'act_name',
            'remark'
		];

		$this->gateway = Omnipay::create( $this->gatewayName );
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

	/**
	 * [doing description]
	 * @throws WechatPayException
	 * @return [type] [description]
	 */
	public function doing(){

		$args = func_get_arg(0);

		$this->gateway->setParameter('wxappid', Configuration::get('wechat.appid'));
		$this->gateway->setMchId(Configuration::get('wechat.mchid'));
		$this->gateway->setKey(Configuration::get('wechat.pay_key'));

		$billno = array_key_exists('mch_billno', $args)? $args['mch_billno'] : null;

		$response = $this->gateway->redPack([
			'mch_billno' => $billno,
			'send_name' => $args['send_name'],
			're_openid' => $args['re_openid'],
			'total_amount' => round($args['total_amount']),
			'total_num' => $args['total_num'],
			'wishing' => $args['wishing'],
			'client_ip' => $args['client_ip'],
			'act_name' => $args['act_name'],
			'remark' => $args['remark'],
			'ssl_cert_path' => Configuration::get('wechat.ssl_cert_path'),
			'ssl_key_path' => Configuration::get('wechat.ssl_key_path')
		])->send();

		if( !$response->isResponseSuccessful() ){
			throw new WechatPayException( $response->getReturnMsg() );
		}
		if( !$response->isSignatureMatched() ){
			throw new WechatPayException( '签名校验失败，可能为非法响应' );
		}
		if( !$response->isResultSuccessful() ){
			throw new WechatPayException( $response->getErrCodeDes() );
		}

		$this->result = $response;
	}

	public function after(){

	}
}
	
?>