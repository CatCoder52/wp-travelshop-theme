<?php
namespace Pressmind;
use \Pressmind\Search\MongoDB\Indexer;
if (php_sapi_name() !== 'cli') {
    die("This file is meant to be run from command line");
}
include_once '../bootstrap.php';
/**
 * @var array $config
 */
if(readline("Type 'yes' and this script will drop all tables in the database '".$config['database']['dbname']."' and it will flush the mongodb '".$config['data']['search_mongodb']['database']['db']."': ") != 'yes'){
    echo "aborted by user\n";
    exit;
}
echo "Dropping all tables in database: ".$config['database']['dbname']."\n";
// Drop all tables
$SQL = "SET FOREIGN_KEY_CHECKS = 0;
SET GROUP_CONCAT_MAX_LEN=32768;
SET @tables = NULL;
SELECT GROUP_CONCAT('`', table_name, '`') INTO @tables
  FROM information_schema.tables
  WHERE table_schema = (SELECT DATABASE());
SELECT IFNULL(@tables,'dummy') INTO @tables;
SET @tables = CONCAT('DROP TABLE IF EXISTS ', @tables);
PREPARE stmt FROM @tables;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
SET FOREIGN_KEY_CHECKS = 1;";

try{
    /**
     * @var \Pdo $db
     */
    $db->execute($SQL);
}catch (\Exception $e){
    echo $e->getMessage();
}
echo "mysql flushed\n";
echo "flushing mongo db\n";
$Indexer = new Indexer();
$Indexer->flushCollections();
echo "mongodb flushed\n";
echo "done\n";