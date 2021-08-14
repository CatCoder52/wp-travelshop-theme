<?php
/**
 * Don't use WordPress functions in this template (for better performance it's called by ajax without the wp bootstrap)

 */

$search = BuildSearch::fromRequest($_GET, 'pm', true, 100);
$mediaObjects = $search->getResults();
$total_result = $search->getTotalResultCount();

$view = 'Teaser2';
if (!empty($_GET['view']) && preg_match('/^[0-9A-Za-z\_]+$/', $_GET['view']) !== false) {
    $view = $_GET['view'];
}
$ids = [];
foreach ($mediaObjects as $mediaObject) {
    $ids[] = $mediaObject->id;
    $data = new stdClass();
    $data->class = 'col-12 col-md-6 col-lg-4';
    echo $mediaObject->render($view, TS_LANGUAGE_CODE, $data);
}