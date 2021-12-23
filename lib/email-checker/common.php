<?php

function emailChecker_checkEmailExpensive(string $email): bool {
    $sleep = random_int(1, 10);

    logStd('Checking Expensive email \'' . $email . '\' is valid');
    logstd('check in ' . $sleep . ' sec');
    sleep($sleep);
    $valid = random_int(0,1) == 1;
    logStd('Checking email \'' . $email . '\' is ' . ($valid ? '' : 'in') . 'valid');
    return $valid;
}

function emailChecker_precheckEmail(string $email): bool {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    $domainParts = explode('.', substr($email, strrpos($email, '@') + 1));
    $tld = $domainParts[count($domainParts) - 1];
    if (!$tld) {
        return false;
    }

    if (!emailChecker_checkTld($tld)) {
        return false;
    }

    return true;
}

function emailChecker_getTldList(): array {
    static $tldList;
    if (is_null($tldList)) {
        $tldList = array_map('trim', explode(PHP_EOL, file_get_contents(pathVar(TLD_LIST_FILE_NAME))));
    }
    return $tldList;
}

function emailChecker_checkTld(string $tld): bool {
    return in_array(strtolower($tld), emailChecker_getTldList(), false);
}

function emailChecker_createEmailCheckJob(array $email) {
    queue_createJob('email-checker', $email);
}

function emailChecker_getEmailsToCheck() {
    return db_select('SELECT `id`, `email` FROM `' . TABLE_EMAILS . '` WHERE `checked` = 0 limit ' . EMAIL_CHECKER_LIMIT);
}

function emailChecker_setEmailChecked(int $emailId) {
    if (!$emailId) {
        err('Email ID is empty');
    }
    db_update(TABLE_EMAILS, ['checked' => 1], '`id`=' . $emailId);
}

function emailChecker_setEmailValid(int $emailId, bool $isValid) {
    if (!$emailId) {
        err('Email ID is empty');
    }
    db_update(TABLE_EMAILS, ['checked' => 1, 'valid' => (int)$isValid], '`id`=' . $emailId);
}
