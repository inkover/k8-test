<?php

function sender_getUsersNearExpire() {
    $validFrom = time() - 3600;
    $validTill = time();
    $query = 'SELECT `u`.`id`, `u`.`username`, `u`.`email` FROM `' . TABLE_USERS . '` AS `u` JOIN `' . TABLE_EMAILS . '` AS `e` ON (`u`.`email`=`e`.`email`) WHERE `u`.`confirmed` = 1 AND `e`.`valid` = 1 AND `u`.`validts` > ' . $validFrom . ' AND `u`.`validts` <= ' . $validTill;
    return db_select($query);
}

function sender_createNotificationJob(array $user) {
    queue_createJob('sender', $user);
}

function sender_sendExpireNotification(array $user) {
    sender_sendEmail(
        EMAIL_FROM,
        $user['email'],
        sender_generateExpireEmailSubject($user),
        sender_generateExpireEmailBody($user)
    );
}

function sender_generateExpireEmailSubject(array $user): string {
    return 'Subscription is expiring soon';
}

function sender_generateExpireEmailBody(array $user): string {
    return $user['username'] . ', your subscription is expiring soon.';
}

function sender_sendEmail($from, $to, $subj, $body) {
    logStd('Sending email \'' . $from . '\' to \'' . $to . '\' with subject \'' . $subj . '\' and body \'' . $body . '\'');
}

function sender_checkUserConfirmCoder($code): string {
    $user = db_select_first('SELECT * FROM `' . TABLE_USERS . '` WHERE `confirm_code`=\'' . db_escape($code) . '\'');
    if (!$user) {
        return 'User not found';
    }
    if ($user['confirmed']) {
        return 'User already confirmed';
    }
    db_update(TABLE_USERS, ['confirmed' => 1], '`id`=' . $user['id']);
    return '';
}
