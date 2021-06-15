<?php
/**
 * Don't use WordPress functions in this template (for better performance it's called by ajax without the wp bootstrap)
 *
 * @var int $id_object_type is defined in pm-search.php
 */

if(empty($_GET['pm-ot']) === true){ // if the id_object_type is not defined by search, we use the information from the route
    $_GET['pm-ot'] = $id_object_type;
}

$page_size = 12;
$search = BuildSearch::fromRequest($_GET, 'pm', true, $page_size);



$mediaObjects = $search->getResults();

/*
if(!empty($_GET['debug'])){
    echo '<pre style="width: 300px;">'.$search->getQuery().'</pre>';
}
*/

$total_result = $search->getTotalResultCount();
$current_page = $search->getPaginator()->getCurrentPage();
$pages = $search->getPaginator()->getTotalPages();
?>


<div class="list-filter-toggle mb-4">
    <button class="btn btn-block btn-secondary list-filter-open">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-adjustments-alt" width="30" height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <rect x="4" y="8" width="4" height="4" />
            <line x1="6" y1="4" x2="6" y2="8" />
            <line x1="6" y1="12" x2="6" y2="20" />
            <rect x="10" y="14" width="4" height="4" />
            <line x1="12" y1="4" x2="12" y2="14" />
            <line x1="12" y1="18" x2="12" y2="20" />
            <rect x="16" y="5" width="4" height="4" />
            <line x1="18" y1="4" x2="18" y2="5" />
            <line x1="18" y1="9" x2="18" y2="20" />
        </svg>
        <span>Reisen filtern</span>
    </button>
</div>

<section class="content-block content-block-list-header">
    <div class="list-header-title h2 mt-0 mb-0 float-lg-left">
        <strong>
            <?php
            echo $total_result . ' ' . (($total_result > 1 || $total_result == 0) ? 'Reisen' : 'Reise');
            ?>
        </strong> gefunden
    </div>
</section>


<section class="content-block content-block-travel-cols">

    <div class="spinner">


        <div class="sk-folding-cube">
            <div class="sk-cube1 sk-cube"></div>
            <div class="sk-cube2 sk-cube"></div>
            <div class="sk-cube4 sk-cube"></div>
            <div class="sk-cube3 sk-cube"></div>
        </div>
        <div class="msg" data-text="Suche Angebote...">Suche Angebote...</div>

        <img class="brand" src="<?php echo SITE_URL;?>/wp-content/themes/travelshop/assets/img/travelshop-logo.svg">

    </div>

    <div id="pm-search-result" class="row">
        <?php

        $view = 'Teaser3';
        if(!empty($_GET['view']) && preg_match('/^[0-9A-Za-z\_]+$/', $_GET['view']) !== false){
            $view = $_GET['view'];
        }

        foreach ($mediaObjects as $mediaObject) {
            $data = new stdClass();
            $data->class = 'col-12 col-md-6 col-lg-4';
            echo $mediaObject->render($view, TS_LANGUAGE_CODE, $data);

        } ?>

        <?php
        if($total_result == 0){
            ?>
            <div class="col-12">
                <p>Zu Ihrer Suchanfrage wurden keine Ergebnisse gefunden. Bitte ändern Sie Ihre Suchanfrage.</p>
                <a href="#" onclick="document.location.href = window.location.href.split('?')[0]">Suche zurücksetzen</a>
            </div>
            <?php
        }
        ?>
    </div>
</section>
<?php
// Pagination
if ($pages > 1) {
    require 'result-pagination.php';
}