<?php

reqEtc('redis');
reqLib('queue/redis');

function queue_getNameArg() {
    $result = pathinfo($GLOBALS['argv'][0], PATHINFO_FILENAME);
    if (empty($result)) {
        err('Queue name is not specified');
    }
    return $result;
}

function queue_waitJobs(string $name) {
    while(true) {
        if (queue_hasJobs($name)) {
            logStd('Start job');
            $job = queue_getNextJob($name);
            queue_doJob($job);
            logStd('Finish job');
        }
        else {
            logStd('Wait');
            usleep(QUEUE_SLEEP_MICROSECONDS);
        }

    }
}
