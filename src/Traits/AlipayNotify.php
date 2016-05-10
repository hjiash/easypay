<?php

namespace ChengFang\EasyPay\Traits;

trait AlipayNotify{

    public static function success(){
        return self::createResponse(true);
    }

    public static function fail(){
        return self::createResponse(false);
    }

    protected static function createResponse($success = true){
        return $success? 'success' : 'fail';
    }
}
