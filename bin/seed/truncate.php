#!/usr/bin/env php
<?php

define('ROOT', dirname(__DIR__, 2));
const APP_TYPE = 'seed';
include ROOT . '/kernel.php';


function seeder_seed() {
    db_query('truncate `users`');
    db_query('truncate `emails`');
	logStd('Truncate success!');
}

boot();
