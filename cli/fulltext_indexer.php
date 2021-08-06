<?php
namespace Pressmind;

use Pressmind\ORM\Object\MediaObject;

if(php_sapi_name() == 'cli') {
    putenv('ENV=DEVELOPMENT');
}

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

$args = $argv;
$args[1] = isset($argv[1]) ? $argv[1] : null;

$media_objects = [];

switch ($args[1]) {
    case null:
        $media_objects = MediaObject::listAll();
        break;
    case 'help':
    case '--help':
    case '-h':
        $helptext = "usage: fulltext_indexer.php [<single id or commaseparated list of ids>]\n";
        $helptext .= "Example usages:\n";
        $helptext .= "php fulltext_indexer.php\n";
        $helptext .= "php fulltext_indexer.php 123456,78901234 <single or multiple ids allowed>\n";
        echo $helptext;
        break;
    default:
        $ids =  array_map('trim', explode(',', $args[1]));
        foreach ($ids as $id) {
            $media_object = new MediaObject(intval($id));
            $media_objects[] = $media_object;
        }
}

foreach ($media_objects as $media_object) {
    $media_object->createSearchIndex();
}
