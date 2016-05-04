<?php

namespace Omnipay\WechatPay\Message;

class RedPackResponse extends BaseAbstractResponse{

    protected function setStatus( $request ){
        $this->is_signature_matched = true;
        $this->is_response_successful = $this->getReturnCode() == 'SUCCESS';
        $this->is_result_successful = $this->getResultCode() == 'SUCCESS';
        $this->is_successful = $this->is_signature_matched & $this->is_response_successful & $this->is_result_successful;
    }

    public function getDeviceInfo(){

        return $this->getParameter( 'device_info' );
    }
}
