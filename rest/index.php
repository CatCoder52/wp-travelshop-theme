<?php
namespace Pressmind;

require_once '../bootstrap.php';
$config = Registry::getInstance()->get('config');
$server = new REST\Server($config['rest']['server']['api_endpoint']);
$server->handle();
