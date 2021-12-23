<?php

# Kernel
const APP_TYPE_CRON  = 'cron';
const APP_TYPE_QUEUE = 'queue';
const APP_TYPE_SEED  = 'seed';
const APP_TYPE_WWW   = 'www';
const APP_TYPES      = [APP_TYPE_CRON, APP_TYPE_QUEUE, APP_TYPE_WWW, APP_TYPE_SEED];

# Loader
const PHP_EXT        = '.php';
const INC_PREFIX_ETC = 'etc';
const INC_PREFIX_LIB = 'lib';
const INC_PREFIX_VAR = 'var';

# Tables
const TABLE_USERS  = 'users';
const TABLE_EMAILS = 'emails';

# Timing and limits
const CRON_MAX_TTL             = 300;
const EMAIL_CHECKER_LIMIT      = 10000;
const QUEUE_SLEEP_MICROSECONDS = 1000000;

const EMAIL_FROM = 'noreply@company.com';

#TLD List
const TLD_LIST_URL = 'http://data.iana.org/TLD/tlds-alpha-by-domain.txt';
const TLD_LIST_FILE_NAME = 'tld.txt';
