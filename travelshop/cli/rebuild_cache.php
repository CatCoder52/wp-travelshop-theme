<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

$mediaObjects = \Pressmind\ORM\Object\MediaObject::listAll();

foreach ($mediaObjects as $mediaObject) {
    echo 'deleting ' . $mediaObject->getId() . ' from cache' . "\n";
    $mediaObject->removeFromCache();
    echo 'adding ' . $mediaObject->getId() . ' to cache' . "\n";
    $mediaObject->addToCache($mediaObject->getId());
    echo $mediaObject->getId() . ' added to cache' . "\n";
}
