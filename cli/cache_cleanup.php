<?php
/**
 * This script is intended to run as cron job every 5 minutes
 */
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
if (php_sapi_name() !== 'cli') {
    die("This file is meant to be run from command line");
}
$CacheService = new \Pressmind\Cache\Service();
echo $CacheService->cleanUp()."\n";