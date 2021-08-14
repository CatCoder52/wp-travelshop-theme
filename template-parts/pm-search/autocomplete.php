<?php
/**
 * Don't use WordPress functions in this template (for better performance it's called by ajax without the wp bootstrap)
 * this file is required in pm-ajax-endpoint.php
 */

$output = new stdClass();
$output->suggestions = [];

if (preg_match('/^[a-zA-Z0-9äöüÄÖÜß\s]+$/', $_GET['q']) !== false) {

    $conditions = [];
    $conditions[] = Pressmind\Search\Condition\Visibility::create(TS_VISIBILTY);
    $conditions[] = Pressmind\Search\Condition\ObjectType::create(TS_TOUR_PRODUCTS);
    $conditions[] = Pressmind\Search\Condition\Fulltext::create($_GET['q'] . '*', ['fulltext'], 'AND', 'BOOLEAN MODE');

    $search = new Pressmind\Search($conditions, [
        'start' => 0,
        'length' => 10
    ], []);

    $mediaObjects = $search->getResults();
    $total_result = $search->getTotalResultCount();

    if ($total_result > 0) {

        $suggestion = new stdClass();
        $suggestion->value = 'Nach "' . $_GET['q'] . '" suchen';
        $suggestion->data = new stdClass();
        $suggestion->data->q = $_GET['q'];
        $suggestion->data->search_request = 'pm-t=' . $_GET['q'];
        $suggestion->data->category = '';
        $suggestion->data->type = 'search';
        $output->suggestions[] = $suggestion;

        foreach ($mediaObjects as $mediaObject) {
            $suggestion = new stdClass();
            $suggestion->value = $mediaObject->name;
            $suggestion->data = new stdClass();
            $suggestion->data->q = $_GET['q'];
            $suggestion->data->search_request = '';
            $suggestion->data->category = 'Reisen';
            $suggestion->data->type = 'link';
            $suggestion->data->url = SITE_URL . $mediaObject->getPrettyUrl(TS_LANGUAGE_CODE);
            $output->suggestions[] = $suggestion;
        }


    }

// translate month names
    $months = ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni',
        'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];

    foreach ($months as $k => $month) {
        if (strpos(strtolower($month), strtolower($_GET['q'])) === 0) {
            $suggestion = new stdClass();
            $suggestion->value = 'Reisen im ' . $month;
            $suggestion->data = new stdClass();
            $suggestion->data->q = $_GET['q'];
            $date = new DateTime();
            $date->setDate($date->format('Y'), ($k + 1), 1);
            $suggestion->data->search_request = 'pm-dr=' . $date->format('Ymd') . '-' . $date->format('Ymt');
            $suggestion->data->category = 'Reisezeiten';
            $suggestion->data->type = 'search';
            $output->suggestions[] = $suggestion;
        }
    }
}

if (count($output->suggestions) == 0) {
    $suggestion = new stdClass();
    $suggestion->value = 'Keine Reisen gefunden';
    $suggestion->data = new stdClass();
    $suggestion->data->q = $_GET['q'];
    $suggestion->data->category = '';
    $suggestion->data->type = 'nothing_found';
    $output->suggestions[] = $suggestion;
}


echo json_encode($output);
