<?php
/**
 * Custom Ajax Endpoint to avoid loading a full wordpress stack load with WordPress's regular admin-ajax.php
 */

require_once 'config-theme.php';
require_once 'bootstrap.php';
require_once 'src/BuildSearch.php';

header('Content-type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Pragma: no-cache");

$Redis = false;
if(defined(PM_REDIS_HOST) === true){
    $Redis = new Redis();
    $Redis->connect(PM_REDIS_HOST, PM_REDIS_PORT);
    $redis_key = 'ts-ajax-rq-' . md5(serialize($_GET));
}

$Output = new stdClass();
$Output->error = true;
$Output->result = null;
$Output->html = array();
$Output->msg = null;
$Output->count = null;

$request = json_decode(file_get_contents('php://input'));

$request = new stdClass();
$request->action = 'get';

if (empty($request->action)) {
    $Output->result = $request;
    echo json_encode($Output);
    exit;
}  else if ($request->action === 'get' && !$_GET['wishlistIDs']) {

    if ($Redis !== false) {
        $cache = $Redis->get($redis_key);
        if (empty($cache) === false) {
            header('X-CACHED-KEY: ' . $redis_key);
            echo $cache;
            exit;
        }
    }


    ob_start();
    require 'template-parts/pm-search/result.php';
    $Output->count = (int)$total_result;
    $Output->html['search-result'] = ob_get_contents();
    ob_end_clean();

    ob_start();
    require 'template-parts/pm-search/filter-vertical.php';
    $Output->html['search-filter'] = ob_get_contents();
    ob_end_clean();


    $Output->error = false;
    $result = json_encode($Output);
    if ($Redis !== false) {
        $Redis->set($redis_key, $result, TS_OBJECT_CACHE_TTL);
    }
    echo $result;
    exit;
} else if($_GET['wishlistIDs']) {
    $wishlistIDs = explode(',', $_GET['wishlistIDs']);
    $wishlistMOs = [];
    foreach($wishlistIDs as $key => $ID) {
        $wishlistMOs[$key] = [];
        $wishlistMOs[$key]['mo'] = new \Pressmind\ORM\Object\MediaObject($ID, true);
        $wishlistMOs[$key]['cp'] = $wishlistMOs[$key]['mo']->getCheapestPrice();
    }
    echo json_encode($wishlistMOs);
} else {
    header("HTTP/1.0 404 Not Found");
    $Output->msg = 'error: action not known';
    $Output->error = true;
    echo json_encode($Output);
    exit;
}