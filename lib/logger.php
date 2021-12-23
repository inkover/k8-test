<?php


function logStd(string $message) {
    $time = explode(' ', microtime());
    echo '[' . date('j.m.Y H:i:s', $time[1]) . '.' . substr(sprintf('%.6f', $time[0]), 2) . '] ' . $message . PHP_EOL;
}

function logErr(Exception $e) {
    logStd('ERROR: ' . $e->getMessage());
}
