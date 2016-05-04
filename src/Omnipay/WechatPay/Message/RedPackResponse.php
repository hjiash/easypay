<?php

namespace Omnipay\WechatPay\Message;

class RedPackResponse extends BaseAbstractResponse{

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
