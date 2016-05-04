<?php

namespace Omnipay\WechatPay\Message;

class RedPackResponse extends BaseAbstractResponse{

    protected function setStates( $request ){
        $this->is_signature_matched = true;
        $this->is_response_successful = $this->getReturnCode() == 'SUCCESS';
        $this->is_result_successful = $this->getResultCode() == 'SUCCESS';
        $this->is_successful = $this->is_response_successful & $this->is_result_successful;
    }

    public function getMchBillno(){
        return $this->getParameter('mch_billno');
    }

    public function getMchId(){
        return $this->getParameter('mch_id');
    }

    public function getWxappid(){
        return $this->getParameter('wxappid');
    }

    public function getReOpenid(){
        return $this->getParameter('re_openid');
    }

    public function getTotalAmount(){
        return $this->getParameter('total_amount');
    }

    public function getSendTime(){
        return $this->getParameter('send_time');
    }

    public function getSendListid(){
        return $this->getParameter('send_listid');
    }
}
