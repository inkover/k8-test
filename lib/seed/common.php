<?php

function seeder_seedUsers()
{
    reqLib('email-checker/common');
    $limit = 10000;
    for ($count = 0; $count <= $limit; $count++) {
        echo '.';
        $email = seeder_generateRandomEmailAddress();
        db_insert(TABLE_USERS, [
            'username' => seeder_generateRandomString(),
            'email' => $email,
            'validts' => time() + 3 * 24 * 3600 + random_int(-60, 600),
            'confirmed' => random_int(0, 1),
            'confirm_code' => seeder_generateRandomString(),
        ]);
        db_insert(TABLE_EMAILS, ['email' => $email]);
    }
}

function seeder_generateRandomEmailAddress(int $maxLenUser = 32, int $maxLenDomain = 64): string
{
    $numeric            = '0123456789';
    $alphabetic         = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $extras             = '.-_';
    $all                = $numeric . $alphabetic . $extras;
    $alphaNumeric       = $alphabetic . $numeric;
    $allLength          = strlen($all);
    $alphabeticLength   = strlen($alphabetic);
    $alphaNumericLength = strlen($alphaNumeric);

    $result = '';

    for ($i = 0; $i < 4; $i++) {
        $result .= $alphabetic[random_int(0, $alphabeticLength - 1)];
    }

    $rndNum = random_int(20, $maxLenUser - 4);

    for ($i = 0; $i < $rndNum; $i++) {
        $result .= $all[random_int(0, $allLength - 1)];
    }

    $result .= '@';

    for ($i = 0; $i < 3; $i++) {
        $result .= $alphabetic[random_int(0, $alphabeticLength - 1)];
    }

    $rndNum = random_int(15, $maxLenDomain - 7);
    for ($i = 0; $i < $rndNum; $i++) {
        $result .= strtolower($all[random_int(0, $allLength - 1)]);
    }

    if (random_int(0, 1) == 0) {
        $result  .= '.';
        $tldList = emailChecker_getTldList();
        $result  .= $tldList[array_rand($tldList)];
    } else {
        for ($i = 0; $i < 4; $i++) {
            $result .= strtolower($alphaNumeric[random_int(0, $alphaNumericLength - 1)]);
        }
    }

    return $result;

}

function seeder_generateRandomString(int $maxLen = 32): string
{
    $numeric          = '0123456789';
    $alphabetic       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $all              = $numeric . $alphabetic;
    $allLength        = strlen($all);
    $alphabeticLength = strlen($alphabetic);

    $result = '';

    for ($i = 0; $i < 4; $i++) {
        $result .= $alphabetic[random_int(0, $alphabeticLength - 1)];
    }

    $rndNum = random_int(20, $maxLen - 4);

    for ($i = 0; $i < $rndNum; $i++) {
        $result .= $all[random_int(0, $allLength - 1)];
    }

    return $result;

}


