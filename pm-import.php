<?php
namespace Pressmind;

use Exception;
use Pressmind\MVC\Request;
use Pressmind\MVC\Response;
use Pressmind\REST\Controller\Ibe;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$request = new Request();

if($request->isPost()) {
    $response = new Response();
    $response->setContentType('application/json');
    try {
        $action = $request->getParameter('action');
        $class = new Ibe($request->getParameter('data'));
        $response->setBody(['success' => true, 'data' => $class->$action()]);
    } catch (Exception $e) {
        $response->setCode(500);
        $response->setBody(['success' => false, 'msg' => $e->getMessage()]);
    }
    $response->send();
}

if($request->isGet()) {
    if($request->getParameter('type') == 'import') {
        $response = new Response();
        $response->setContentType('application/json');
        try {
            $importer = new Import('mediaobject');
            $importer->importMediaObject($request->getParameter('id_media_object'));
            $importer->postImport();
            $media_object = new ORM\Object\MediaObject($request->getParameter('id_media_object'));
            $url = WEBSERVER_HTTP.$media_object->getPrettyUrl().'?preview=1&no_cache='.uniqid();
            if($request->getParameter('preview') == "1") {
                $config = Registry::getInstance()->get('config');
                $response->setContentType('text/html');
                $response->setBody('You will be redirected to Preview Page: ' . $url);
                $response->addHeader('Location', $url);
            } else {
                $response->setBody(['status' => 'Code 200: Import erfolgreich', 'url' => $url, 'msg' => implode("\n", $importer->getLog())]);
            }
        } catch (Exception $e) {
            $response->setCode(500);
            $response->setBody(['status' => 'Code 500: Es ist ein Fehler aufgetreten', 'msg' => $e->getMessage()]);
        }
        $response->send();
    }
}
