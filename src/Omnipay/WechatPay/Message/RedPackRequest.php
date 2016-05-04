<?php

namespace Omnipay\WechatPay\Message;

class RedPackRequest extends BaseAbstractRequest{

    protected $interface_url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';

    protected function validateData(){

        $this->validate(
            'mch_id',
            'mch_billno',
            'wxappid',
            'send_name',
            're_openid',
            'total_amount',
            'total_num',
            'wishing',
            'client_ip',
            'act_name',
            'remark',
            'ssl_cert_path',
            'ssl_key_path'
        );

    }

    public function getData(){

        $this->validateData();

        $request_data = [
            'mch_billno' => $this->getMchBillno(),
            'wxappid' => $this->getWxappid(),
            'mch_id' => $this->getMchId(),
            'send_name' => $this->getSendName(),
            're_openid' => $this->getReOpenid(),
            'total_amount' => $this->getTotalAmount(),
            'total_num' => $this->getTotalNum(),
            'wishing' => $this->getWishing(),
            'client_ip' => $this->getClientIp(),
            'act_name' => $this->getActName(),
            'remark' => $this->getRemark(),
            'nonce_str' => $this->getNonceStr()
        ];

        $request_data = array_filter( $request_data, function( $value ){

            return !is_null( $value );
        });

        $request_data['sign'] = $this->getParamsSignature( $request_data, $this->getKey() );
        
        return $request_data;
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData( $data ){

        $curl_options = [
            'cert' => true,
            'ssl_cert_path' => $this->getSslCertPath(),
            'ssl_key_path' => $this->getSslKeyPath()
        ];

        $result = parent::sendData( $data, $curl_options );

        return $result;
    }

    public function setMchBillno($value = null){
        if(is_null($value)){
            $billno = date('YmdHis').substr(microtime(), 2, 4);
            $billno = $this->getMchId().$billno;

            return $this->setParameter('mch_billno', $billno);
        }

        return $this->setParameter('mch_billno', $value);
    }

    public function getMchBillno(){
        return $this->getParameter('mch_billno');
    }

    public function setWxappid($value){
        return $this->setParameter('wxappid', $value);
    }

    public function getWxappid(){
        return $this->getParameter('wxappid');
    }

    public function setMchId($value){
        return $this->setParameter('mch_id', $value);
    }

    public function getMchId(){
        return $this->getParameter('mch_id');
    }

    public function setSendName($value){
        return $this->setParameter('send_name', $value);
    }

    public function getSendName(){
        return $this->getParameter('send_name');
    }

    public function setReOpenid($value){
        return $this->setParameter('re_openid', $value);
    }

    public function getReOpenid(){
        return $this->getParameter('re_openid');
    }

    public function setTotalAmount($value){
        return $this->setParameter('total_amount', $value);
    }

    public function getTotalAmount(){
        return $this->getParameter('total_amount');
    }

    public function setTotalNum($value){
        return $this->setParameter('total_num', $value);
    }

    public function getTotalNum(){
        return $this->getParameter('total_num');
    }

    public function setWishing($value){
        return $this->setParameter('wishing', $value);
    }

    public function getWishing(){
        return $this->getParameter('wishing');
    }

    public function setClientIp($value){
        return $this->setParameter('client_ip', $value);
    }

    public function getClientIp(){
        return $this->getParameter('client_ip');
    }

    public function setActName($value){
        return $this->setParameter('act_name', $value);
    }

    public function getActName(){
        return $this->getParameter('act_name');
    }

    public function setRemark($value){
        return $this->setParameter('remark', $value);
    }

    public function getRemark(){
        return $this->getParameter('remark');
    }

    public function setKey($value){
        return $this->setParameter('key', $value);
    }

    public function getKey(){
        return $this->getParameter('key');
    }

    public function setSslCertPath( $value ){
        return $this->setParameter( 'ssl_cert_path', $value );
    }

    public function getSslCertPath(){
        return $this->getParameter( 'ssl_cert_path' );
    }

    public function setSslKeyPath( $value ){
        return $this->setParameter( 'ssl_key_path', $value );
    }

    public function getSslKeyPath(){
        return $this->getParameter( 'ssl_key_path' );
    }
}
