<?php

$core = dirname(__FILE__, 2);
$core = str_replace('\\', '/', $core) . '/';
define('CORE', $core);

###

require_once 'AutoLoadClass.php';

spl_autoload_register('AutoLoadClass::register');

###

TMPHP\App\Brain::init();
