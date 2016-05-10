<?php

namespace ChengFang\EasyPay\Traits;

trait AlipayNotify{

    public function success(){
        return self::createResponse(true);
    }

    public function fail(){
        return self::createResponse(false);
    }

    protected function createResponse($success = true){
        return $success? 'success' : 'fail';
    }
}
