<?php
/**
 * This file is called from the pressmind® PIM Application
 */

require_once 'config-theme.php';
require_once 'bootstrap.php';

$id_media_object = (int)$_GET['id_media_object'];
if(empty($id_media_object) === true){
    header('Bad Request', 400);
    echo 'Parameter "id_media_object" is not defined';
    exit;
}

$mediaObject = new Pressmind\ORM\Object\MediaObject($id_media_object);
$url = SITE_URL.'/'.$mediaObject->getPrettyUrl().'?no_cache='.time();
header('Location: '.$url,TRUE,302);
exit();