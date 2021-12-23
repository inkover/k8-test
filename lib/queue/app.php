<?php

function runApp() {
    reqLib('queue/common');
    try {
        queue_waitJobs(queue_getNameArg());
    }
    catch (Exception $e) {
        logErr($e);
    }

}
