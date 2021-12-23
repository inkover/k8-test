<?php


function cron_checkIsRunning(): bool {
    $path = cron_getRunPath();
    if (!file_exists($path)) {
        return false;
    }
    $data = @unserialize(@file_get_contents($path), ['allowed_classes' => []]);
    if (!$data) {
        return false;
    }

    @exec('ps ' . $data['pid'], $res);
    if ((count($res) < 2)) {
        unlink($path);
        return false;
    }

    if (microtime(true) - (int)$data['time'] > CRON_MAX_TTL) {
        @exec('kill -9 ' . $data['pid']);
        unlink($path);
        return false;
    }

    return true;
}

function cron_setIsRunning() {
    file_put_contents(cron_getRunPath(), serialize([
        'pid' => getmypid(),
        'time' => time()
    ]));
}

function cron_setNotRunning() {
    $path = cron_getRunPath();
    if (!file_exists($path)) {
        return;
    }
    unlink($path);
}

function cron_getRunPath(): string {
    return pathVar('run/' . cron_getName());
}

function cron_getName(): string {
    return pathinfo($GLOBALS['argv'][0], PATHINFO_FILENAME);
}
