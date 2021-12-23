#!/usr/bin/env php
<?php

define('ROOT', dirname(__DIR__, 2));
const APP_TYPE = 'seed';
include ROOT . '/kernel.php';


function seeder_seed() {
	reqLib('seed/common');
    seeder_seedUsers();
}

boot();
