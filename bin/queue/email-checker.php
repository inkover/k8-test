#!/usr/bin/env php
<?php

define('ROOT', dirname(__DIR__, 2));
const APP_TYPE = 'queue';
include ROOT . '/kernel.php';


function queue_doJob(array $job) {
    try {
        reqLib('db/common');
        reqLib('email-checker/common');
        if (empty($job['email'])) {
            err('Email is empty');
        }
        emailChecker_setEmailValid((int)$job['id'], emailChecker_checkEmailExpensive($job['email']));
    }
    catch (Exception $e) {
        logErr($e);
    }
}

boot();
