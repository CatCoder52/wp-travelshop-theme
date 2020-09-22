<?php

//@todo


return;


/**
 * @var $search
 */
if(empty($search) === false){
    // get the min and max price, based on the current search
    $pRangeFilter = new Pressmind\Search\Filter\PriceRange($search);
    $pRange = $pRangeFilter->getResult();
}

if (isset($_GET['pm-pr']) === true && preg_match('/^([0-9]+)\-([0-9]+)$/', $_GET['pm-pr'], $m) > 0) {
    $from = $m[1];
    $to = $m[2];
}else{
    $from = $pRange->min;
    $to = $pRange->max;
}


?>
<div class="list-filter-box list-filter-box-price">
    <div class="list-filter-box-title">
        <strong>Preis</strong>
    </div>
    <div class="list-filter-box-body">

        <input type="text" class="js-range-slider" name="pm-pr" value=""
               data-type="double"
               data-min="<?php echo empty($pRange->min) ? 0 : $pRange->min; ?>"
               data-max="<?php echo empty($pRange->max) ? 1000 : $pRange->max; ?>"
               data-from="<?php echo $from; ?>"
               data-to="<?php echo $to; ?>"
               data-grid="false"
               data-prefix="€ "
               data-step="100"
        />

    </div>
</div>