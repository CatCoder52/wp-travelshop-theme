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
    case 'indexes':
        $Indexer = new Indexer();
        $Indexer->createCollectionIndexes();
        break;
    case 'flush':
        $Indexer = new Indexer();
        $Indexer->flushCollections();
        break;
    case 'create_collections':
        $Indexer = new Indexer();
        $Indexer->createCollectionsIfNotExists();
        break;
    case 'help':
    case '--help':
    case '-h':
    default:
        $helptext = "usage: index_mongo.php [all | mediaobject | destroy | indexes | create_collections] [<single id or commaseparated list of ids>]\n";
        $helptext .= "Example usages:\n";
        $helptext .= "php index_mongo.php all\n";
        $helptext .= "php index_mongo.php mediaobject 12345,12346  <single/multiple ids allowed  / imports one or more media objects>\n";
        $helptext .= "php index_mongo.php destroy 12345,12346  <single/multiple ids allowed  / removes this objects from the mongodb best price cache>\n";
        $helptext .= "php index_mongo.php indexes  <sets the required indexes for each collection>\n";
        $helptext .= "php index_mongo.php flush  <flushes all collections>\n";
        $helptext .= "php index_mongo.php create_collections  <creates collections for each index definition configured in pm-config>\n";
        echo $helptext;
}
