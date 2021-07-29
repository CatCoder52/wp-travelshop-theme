<?php

/**
 *  <code>
 *  $args['class'] // main-color, silver, transparent
 * </code>
 * @var array $args
 */


global $PMTravelShop;
use Pressmind\Travelshop\RouteProcessor;

if(empty($id_object_type) === true){
    $id_object_type = TS_TOUR_PRODUCTS;
}

$search = new Pressmind\Search(
    [
        Pressmind\Search\Condition\Visibility::create(TS_VISIBILTY),
        Pressmind\Search\Condition\ObjectType::create($id_object_type),
    ]
);

?>
<form method="GET" action="<?php echo site_url().'/'.$PMTravelShop->RouteProcessor->get_url_by_object_type(TS_TOUR_PRODUCTS).'/' ?>">
    <input type="hidden" name="pm-ot" value="<?php echo $id_object_type;?>">
    <div class="search-wrapper">
        <?php if(!empty($args['headline'])){?>
        <div class="h1 text-md-center mt-0 mb-2 mb-4">
            <?php echo $args['headline'];?>
        </div>
        <?php } ?>
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

                <?php
                // draw category tree based search fields
                foreach(TS_SEARCH as $searchItem){ ?>
                    <div class="col-12 col-md-3">
                        <?php
                        list($id_tree, $fieldname, $name, $condition_type) = array_values($searchItem);
                        require 'search/category-tree-dropdown.php';
                        ?>
                    </div>
                    <?php
                } ?>

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