<?php
/**
 * to make this schedule handler work add a cronjob to your webservers crontab that executes this file every minute
 * e.g: * * * * * php /your/install/path/application/cli/cron.php  > /dev/null 2>&1
 */

use Pressmind\Log\Writer;
use Pressmind\Scheduler;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

$scheduler = new Scheduler();
try {
    $scheduler->walk();
} catch (Exception $e) {
    Writer::write($e->getMessage(), Writer::OUTPUT_FILE, 'scheduler', Writer::TYPE_ERROR);
}
