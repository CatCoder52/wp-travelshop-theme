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

<!-- CONTENT_SECTION_LIST_HEADER: START -->
<section class="content-block content-block-list-header">
    <div class="list-header-title h2 mt-0 mb-0 float-lg-left">
        <strong>
            <?php
            echo $total_result . ' ' . (($total_result > 1 || $total_result == 0) ? 'Reisen' : 'Reise');
            ?>
        </strong> gefunden
    </div>
</section>
<!-- CONTENT_SECTION_LIST_HEADER: END -->


<!-- CONTENT_SECTION_TRAVEL_COLS: START -->
<section class="content-block content-block-travel-cols">
    <div id="pm-search-result" class="row">
        <?php
        foreach ($mediaObjects as $mediaObject) {
            $data = new stdClass();
            $data->class = 'col-12 col-md-6 col-lg-4';
            echo $mediaObject->render('Teaser1', 'de', $data);

        } ?>

        <?php
        if($total_result == 0){
            ?>
            <div class="col-12">
                <p>Zu Ihrer Suchanfrage wurden keine Ergebnisse gefunden. Bitte ändern Sie Ihre Suchanfrage.</p>
                <a href="<?php echo SITE_URL.parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);?>">Suche zurücksetzen</a>
            </div>
            <?php
        }
        ?>
    </div>
</section>
<!-- CONTENT_SECTION_TRAVEL_COLS: END -->
<?php
// Pagination
if ($pages > 1) {
    require 'result-pagination.php';
}