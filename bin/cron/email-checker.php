#!/usr/bin/env php
<?php

define('ROOT', dirname(__DIR__, 2));
const APP_TYPE = 'cron';
include ROOT . '/kernel.php';


function cron_startTask() {
    reqLib('db/common');
    reqLib('queue/common');
    reqLib('email-checker/common');
    foreach (emailChecker_getEmailsToCheck() as $email) {
        try {
            emailChecker_setEmailChecked((int)$email['id'], false);
            if (!emailChecker_precheckEmail($email['email'])) {
                echo '!';
                emailChecker_setEmailValid((int)$email['id'], false);
                continue;
            }
            echo '.';
            emailChecker_createEmailCheckJob($email);
        }
        catch (Exception $e) {
            logErr($e);
        }
    }
}

boot();
