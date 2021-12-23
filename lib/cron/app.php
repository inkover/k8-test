<?php

function runApp() {
    reqLib('cron/common');
    if (cron_checkIsRunning()) {
        return;
    }
    cron_setIsRunning();
    cron_startTask();
    cron_setNotRunning();

}
