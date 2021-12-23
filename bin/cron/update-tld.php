#!/usr/bin/env php
<?php


define('ROOT', dirname(__DIR__, 2));
const APP_TYPE = 'cron';
include ROOT . '/kernel.php';


function cron_startTask() {
    $content = @file_get_contents(TLD_LIST_URL);
	$content = strtolower($content);
	if (!$content) {
		return;
	}
	@file_put_contents(pathVar(TLD_LIST_FILE_NAME), $content);
}

boot();
