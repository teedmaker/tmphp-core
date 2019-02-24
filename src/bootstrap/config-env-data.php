<?php

$dotenvFile = '../../../../../.env';

if (!file_exists($dotenvFile)) {
    copy(__DIR__.'/../../../../../.env.sample', __DIR__.'/../../../../../.env');
}

$dotenv = new Dotenv\Dotenv(__DIR__, $dotenvFile);
$dotenv->load();
