<?php

function err(string $message) {
    throw new \Exception($message);
}

function boot() {

    require_once ROOT . '/lib/loader.php';
    require_once ROOT . '/lib/constants.php';

    reqLib('logger');

    if (!defined('ROOT')) {
        err('Root is not defined');
    }

    if (!defined('APP_TYPE')) {
        err('App type is not defined');
    }

    if (!in_array(APP_TYPE, APP_TYPES)) {
        err('Unsupported app type \'' . APP_TYPE . '\'');
    }

    reqLib(APP_TYPE . '/app');

    runApp();
}
