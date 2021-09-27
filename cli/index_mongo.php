<?php
/**
 * Manages the MongoDB best price search index
 */
use Pressmind\Import;
use Pressmind\Log\Writer;
use \Pressmind\Search\MongoDB\Indexer;
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
$args = $argv;
$args[1] = isset($argv[1]) ? $argv[1] : null;
if (php_sapi_name() !== 'cli') {
    die("This file is meant to be run from command line");
}
switch ($args[1]) {
    case 'all':
        $Indexer = new Indexer();
        $Indexer->createIndexes();
        break;
    case 'mediaobject':
        $Indexer = new Indexer();
        $Indexer->upsertMediaObject(array_map('intval', explode(',', $args[2])));
        break;
    case 'destroy':
        $Indexer = new Indexer();
        $Indexer->deleteMediaObject(array_map('intval', explode(',', $args[2])));
        break;
    case 'help':
    case '--help':
    case '-h':
    default:
        $helptext = "usage: index_mongo.php [all | mediaobject | destroy] [<single id or commaseparated list of ids>]\n";
        $helptext .= "Example usages:\n";
        $helptext .= "php index_mongo.php all\n";
        $helptext .= "php index_mongo.php mediaobject 12345,12346  <single/multiple ids allowed  / imports one or more media objects>\n";
        $helptext .= "php index_mongo.php destroy 12345,12346  <single/multiple ids allowed  / removes this objects from the mongodb best price cache>\n";
        echo $helptext;
}
