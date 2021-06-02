<?php
/**
 * @var \Pressmind\Search $search
 */

if(empty($search) === false){

    // get the min and max price, based on the current search
    $pRangeFilter = new Pressmind\Search\Filter\PriceRange($search);
    $pRange = $pRangeFilter->getResult();

    if(empty($pRange->min) || empty($pRange->max)){
        return;
    }

    // set the price range to the closest 100, 1000 and so on...
    $pRange->min = str_pad(substr($pRange->min, 0,1), strlen($pRange->min), 0);
    $pRange->max = str_pad(substr($pRange->max , 0,1)+1, strlen($pRange->max ) + strlen(substr($pRange->max, 0,1)+1)-1, 0);
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
        <?php
        // ion.rangeSlider is used here, see API Docu: @link http://ionden.com/a/plugins/ion.rangeSlider/api.html
        ?>
        <input type="text" class="js-range-slider" name="pm-pr" value=""
               data-type="double"
               data-min="<?php echo empty($pRange->min) ? 0 : $pRange->min; ?>"
               data-max="<?php echo empty($pRange->max) ? 1000 : $pRange->max; ?>"
               data-from="<?php echo $from; ?>"
               data-to="<?php echo $to; ?>"
               data-grid="false"
               data-prefix="€ "
               data-step="100"
               data-hide-min-max="1"
               data-hide-min-min="1"
               data-input-values-separator="-"
               data-disable="<?php
               // disable the picker if there is no plausible step to pick
               echo ($pRange->min == $pRange->max || ($pRange->max - $pRange->min) == 100) ? 'true' : 'false';
               ?>"
        />

    </div>
</div>