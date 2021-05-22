<?php
/**
 * Don't use WordPress functions in this template (for better performance it's called by ajax without the wp bootstrap)
 *
 * @var int $id_object_type is defined in pm-search.php
 */

if (empty($_GET['pm-ot']) === true) { // if the id_object_type is not defined by search, we use the information from the route
    $_GET['pm-ot'] = $id_object_type;
}

$page_size = 12;
$search = BuildSearch::fromRequest($_GET, 'pm', true, $page_size);
$mediaObjects = $search->getResults();

$view = 'Teaser1';
if (!empty($_GET['view']) && preg_match('/^[0-9A-Za-z\_]+$/', $_GET['view']) !== false) {
    $view = $_GET['view'];
}

foreach ($mediaObjects as $mediaObject) {
    $data = new stdClass();
    $data->class = 'col-12 col-md-6 col-lg-4';
    echo $mediaObject->render($view, TS_LANGUAGE_CODE, $data);
}