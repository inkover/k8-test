#!/usr/bin/env php
<?php

define('ROOT', dirname(__DIR__, 2));
const APP_TYPE = 'queue';
include ROOT . '/kernel.php';


function queue_doJob(array $job) {
    try {
        reqLib('db/common');
        reqLib('sender/common');
        if (empty($job['email'])) {
            err('User is empty');
        }
        sender_sendExpireNotification($job);
    }
    catch (Exception $e) {
        logErr($e);
    }
}

boot();
