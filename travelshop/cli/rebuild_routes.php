<?php
namespace Pressmind;

use Exception;
use Pressmind\DB\Adapter\Pdo;
use Pressmind\ORM\Object\MediaObject;
use Pressmind\ORM\Object\Route;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
/** @var Pdo $db */
$db = Registry::getInstance()->get('db');
/** @var MediaObject[] $mediaObjects */
$mediaObjects = MediaObject::listAll();
foreach ($mediaObjects as $mediaObject) {
    $db->delete('pmt2core_routes', ['id_media_object = ?', $mediaObject->getId()]);
    try {
        $new_routes = $mediaObject->buildPrettyUrls();
        foreach ($new_routes as $new_route) {
            $route = new Route();
            $route->language = 'de';
            $route->id_object_type = $mediaObject->id_object_type;
            $route->id_media_object = $mediaObject->getId();
            $route->route = $new_route;
            $route->create();
        }
    } catch (Exception $e) {
        echo 'ERROR for MediaObject ID ' . $mediaObject->getId() . ': ' . $e->getMessage() . "\n";
    }
}
