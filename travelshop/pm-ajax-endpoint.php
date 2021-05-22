<?php
/**
 * Custom Ajax Endpoint to avoid loading a full wordpress stack load with WordPress's regular admin-ajax.php
 */

require_once 'config-theme.php';
require_once 'bootstrap.php';
require_once 'src/BuildSearch.php';
require_once 'src/RouteProcessor.php';

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


if (empty($_GET['action'])) {
    $Output->result = $request;
    echo json_encode($Output);
    exit;
}  else if ($_GET['action'] == 'search') {

    if ($Redis !== false) {
        $cache = $Redis->get($redis_key);
        if (empty($cache) === false) {
            header('X-CACHED-KEY: ' . $redis_key);
            echo $cache;
            exit;
        }
    }

    /**
     * @var int $total_result
     */
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

}  else if ($_GET['action'] == 'wishlist'){

    ob_start();
    require 'template-parts/pm-search/wishlist-result.php';
    $Output->html['wishlist-result'] = ob_get_contents();
    ob_end_clean();

    $Output->error = false;
    $result = json_encode($Output);
    echo $result;
    exit;

}else if ($_GET['action'] == 'autocomplete') {

    ob_start();
    require 'template-parts/pm-search/autocomplete.php';
    $output = ob_get_contents();
    ob_end_clean();
    echo $output;
    exit;

}else {

    header("HTTP/1.0 400 Bad Request");
    $Output->msg = 'error: action not known';
    $Output->error = true;
    echo json_encode($Output);
    exit;

}