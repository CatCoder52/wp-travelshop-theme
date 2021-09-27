<?php
/**
 * Custom Ajax Endpoint to avoid loading a full wordpress stack load with WordPress's regular admin-ajax.php
 */

use \Pressmind\Travelshop\Search;
use \Pressmind\ORM\Object\MediaObject;

//error_reporting(-1);
//ini_set('display_errors', 'On');

require_once 'config-theme.php';
require_once 'bootstrap.php';
require_once 'src/Search.php';
require_once 'src/BuildSearch.php';
require_once 'src/RouteHelper.php';
require_once 'src/PriceHandler.php';
require_once 'src/Template.php';
header('Content-type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Pragma: no-cache");
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
} else if ($_GET['action'] == 'search') {
    $args = Search::getResult($_GET, 2, 12, true, false);
    ob_start();
    require 'template-parts/pm-search/result.php';
    $Output->count = (int)$args['total_result'];
    $Output->html['search-result'] = ob_get_contents();
    ob_end_clean();
    ob_start();
    require 'template-parts/pm-search/filter-vertical.php';
    $Output->html['search-filter'] = ob_get_contents();
    ob_end_clean();
    $Output->error = false;
    $result = json_encode($Output);
    echo $result;
    exit;
} else if ($_GET['action'] == 'wishlist'){
    /**
     * @var array $result
     * @var array $ids
     */
    ob_start();
    require 'template-parts/pm-search/wishlist-result.php';
    $Output->count = $result['total_result'];
    $Output->mongo = $result['mongodb'];
    $Output->ids = $ids;
    $Output->html['wishlist-result'] = ob_get_contents();
    ob_end_clean();
    $Output->error = false;
    $result = json_encode($Output);
    echo $result;
    exit;
} else if ($_GET['action'] == 'searchbar'){
    $args = Search::getResult($_GET, 2, 12, true, false);
    ob_start();
    require 'template-parts/pm-search/search/searchbar-form.php';
    $Output->html['main-search'] = ob_get_contents();
    ob_end_clean();
    $Output->error = false;
    $result = json_encode($Output);
    echo $result;
    exit;
} else if ($_GET['action'] == 'autocomplete') {
    ob_start();
    require 'template-parts/pm-search/autocomplete.php';
    $output = ob_get_contents();
    ob_end_clean();
    echo $output;
    exit;
} else if ($_GET['action'] == 'pm-view') {
    $id_media_object = (int)$_GET['pm-id'];
    if(empty($id_media_object)){
        exit;
    }
    $view = 'Teaser1';
    if(!empty($_GET['view']) && preg_match('/^[0-9A-Za-z\_]+$/', $_GET['view']) !== false){
        $view = $_GET['view'];
    }
    $mediaObject = new MediaObject($id_media_object);
    $Output->error = false;
    $Output->html = $mediaObject->render($view,TS_LANGUAGE_CODE);
    $result = json_encode($Output);
    echo $result;
    exit;
}else{
    header("HTTP/1.0 400 Bad Request");
    $Output->msg = 'error: action not known';
    $Output->error = true;
    echo json_encode($Output);
    exit;
}
