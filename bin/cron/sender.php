#!/usr/bin/env php
<?php

define('ROOT', dirname(__DIR__, 2));
const APP_TYPE = 'cron';
include ROOT . '/kernel.php';


function cron_startTask() {
    reqLib('db/common');
    reqLib('queue/common');
    reqLib('sender/common');
    foreach (sender_getUsersNearExpire() as $user) {
        try {
            echo '.';
            sender_createNotificationJob($user);
        }
        catch (Exception $e) {
            logErr($e);
        }
    }
}

boot();
