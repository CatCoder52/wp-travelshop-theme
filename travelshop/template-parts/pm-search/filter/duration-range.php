<?php

// @todo Test and Check... not ready
// get the min and max price, based on the current search
$dRangeFilter = new Pressmind\Search\Filter\Duration($search);
$dRange = $dRangeFilter->getResult();

if (isset($_GET['pm-dur']) === true && preg_match('/^([0-9]+)\-([0-9]+)$/', $_GET['pm-dur'], $m) > 0) {
    $from = $m[1];
    $to = $m[2];
}else{
    $from = $dRange->min;
    $to = $dRange->max;
}


?>
<div class="list-filter-box list-filter-box-price">
    <div class="list-filter-box-title">
        <strong>Dauer</strong>
    </div>
    <div class="list-filter-box-body">

        <input type="text" class="js-range-slider" name="pm-pr" value=""
               data-type="double"
               data-min="<?php echo $dRange->min; ?>"
               data-max="<?php echo $dRange->max; ?>"
               data-from="<?php echo $from; ?>"
               data-to="<?php echo $to; ?>"
               data-grid="false"
               data-prefix="€ "
               data-step="100"
        />

    </div>
</div>