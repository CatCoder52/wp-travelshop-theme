<?php
/**
 * Don't use WordPress functions in this template (for better performance it's called by ajax without the wp bootstrap)
 */
use Pressmind\Travelshop\Template;
use Pressmind\Travelshop\Search;
$result = Search::getResult($_GET ,2, 12, false, false);
$view = 'Teaser2';
if (!empty($_GET['view']) && preg_match('/^[0-9A-Za-z\_]+$/', $_GET['view']) !== false) {
    $view = $_GET['view'];
}
$ids = [];
foreach ($result['items'] as $item) {
    $ids[] = $item['id_media_object'];
    $item['class'] = 'col-12 col-md-6 col-lg-4';
    echo Template::render(__DIR__.'/../pm-views/'.$view.'.php', $item);
}