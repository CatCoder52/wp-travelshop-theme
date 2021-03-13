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

<!-- CONTENT_SECTION_LIST_HEADER: START -->
<section class="content-block content-block-list-header">

    <div class="list-filter-toggle mb-4 ">
        <button class="btn btn-block btn-secondary list-filter-open">
            <i class="la la-filter"></i> Reisen filtern
        </button>
    </div>

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
            $data->class = 'col-12 col-sm-6 col-lg-4';
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