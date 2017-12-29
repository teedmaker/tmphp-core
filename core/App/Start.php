<?php

$corePath = dirname(__FILE__, 2);
$corePath = str_replace('\\', '/', $corePath) . '/';
define('CORE', $corePath);

require_once 'AutoLoadClass.php';

spl_autoload_register('AutoLoadClass::register');


