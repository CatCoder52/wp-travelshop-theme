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
            Finde deine Traumreise.
        </div>

        <div class="search-wrapper--inner search-box">
            <div class="row">

                <div class="col-12 col-md-3">
                    <?php
                    require 'search/string-search.php';
                    ?>
                </div>

                <div class="col-12 col-md-3 travelshop-datepicker">
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <circle cx="10" cy="10" r="7" />
                            <line x1="21" y1="21" x2="15" y2="15" />
                        </svg> 
                        <span class="search-bar-total-count" data-default="Suchen" data-total-count-singular="Reise" data-total-count-plural="Reisen">Suchen</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>