<?php

namespace ChengFang\EasyPay\Traits;

trait WechatPayNotify{
    use \Omnipay\WechatPay\Traits\XMLTrait;

    public function success($message = null){
        return self::createResponse(true, $message);
    }

    public function fail($message = null){
        return self::createResponse(false, $message);
    }

    protected function createResponse($success = true, $message = null){
        $returnCode = $success? 'SUCCESS' : 'FAIL';
        $return = [
            'return_code' => $returnCode,
        ];
        if(!is_null($message)){
            $return['return_msg'] = $message;
        }

        return $this->convertArrayToXml($return);
    }
}
