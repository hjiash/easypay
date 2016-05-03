<?php

require __DIR__.'/vendor/autoload.php';

use ChengFang\EasyPay\Configuration;

Configuration::testCallStatic();
Configuration::staticFunction();

$configuration = new Configuration;
$configuration->normalFunction();

$configuration->staticFunction();

call_user_func_array([$configuration, 'normalFunction'], []);
