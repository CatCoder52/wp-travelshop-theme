<?php

global $PMTravelShop;
use Pressmind\Travelshop\RouteProcessor;

if(empty($id_object_type) === true){
    $id_object_type = TS_TOUR_PRODUCTS;
}

$search = new Pressmind\Search(
    [
        //Pressmind\Search\Condition\Category::create('zielgebiet_default', ['304E15ED-302F-CD33-9153-14B8C6F955BD', '4C5833CB-F29A-A0F4-5A10-14B762FB4019', '78321653-CF81-2EF1-ED02-9D07E01651C1']),
        //Pressmind\Search\Condition\PriceRange::create(100, 3000),
        //Pressmind\Search\Condition\DurationRange::create(0, 30),
        Pressmind\Search\Condition\Visibility::create(TS_VISIBILTY),
        Pressmind\Search\Condition\ObjectType::create($id_object_type),
    ]
);

?>
<form method="GET">
    <div class="search-wrapper">
        <div class="h1 text-md-center mt-0 mb-2 mb-4">
            Finden Sie ihre Traumreise.
        </div>

        <div class="search-wrapper--inner search-box">
            <div class="row">

                <div class="col-12 col-md-3">
                    <?php
                    require 'search/string-search.php';
                    ?>
                </div>

                <div class="col-12 col-md-3">
                    <?php
                    require 'search/date-picker.php';
                    ?>
                </div>
                <div class="col-12 col-md-3">
                    <?php

                    $id_tree = 1207;
                    $name = 'Zielgebiete';
                    $fieldname = 'zielgebiet_default';
                    require 'search/category-tree-dropdown.php';
                    ?>
                </div>
                <div class="col-12 col-md-3">
                    <?php

                    $id_tree = 1206;
                    $name = 'Reiseart';
                    $fieldname = 'reiseart_default';
                    require 'search/category-tree-dropdown.php';
                    ?>
                </div>
                <div class="col-12 col-md-3 mb-md-0">
                    <div class="from-group mb-0">
                        <label class="d-none d-md-block">&nbsp;</label>
                        <a class="btn btn-primary btn-block" href="<?php echo site_url().'/'.$PMTravelShop->RouteProcessor->get_url_by_object_type(TS_TOUR_PRODUCTS).'/'; ?>">
                            <i class="la la-search"></i> <span class="search-bar-total-count" data-default="Suchen" data-total-count-singular="Reise" data-total-count-plural="Reisen">Suchen</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>