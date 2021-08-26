<?php
/**
 * @var \Pressmind\Search $search
 *
 * @var int $id_object_type
 */

/**
 * Get the current min/max daterange for this object type and .
 * Use the wp transient cache for a better performance
 */
$transient = 'ts_min_max_date_range_'.md5(serialize($search->getConditions()));
if (($dRange = get_transient( $transient)) === false) {
    $dRangeFilter = new Pressmind\Search\Filter\DepartureDate($search);
    $dRange = $dRangeFilter->getResult();
    set_transient($transient, $dRange, 60);
}

$minDate = $maxDate = $minYear = $maxYear = '';
if(!empty($dRange->from) && !empty($dRange->to)){
    $minDate = $dRange->from->format('d/m/Y');
    $minYear = $dRange->from->format('Y');
    $maxDate = $dRange->to->format('d/m/Y');
    $maxYear = $dRange->to->format('Y');
}

?>

<div class="form-group mb-md-0">
    <label for="">Reisezeitraum</label>
    <div>
        <input type="text"
            class="form-control travelshop-datepicker-input"
            data-type="daterange"
            name="pm-dr"
            autocomplete="off"
            readonly
            data-mindate="<?php echo $minDate;?>"
            data-maxdate="<?php echo $maxDate;?>"
            data-minyear="<?php echo $minYear;?>"
            data-maxyear="<?php echo $maxYear;?>"
            placeholder="egal" value="<?php
        if (empty($_GET['pm-dr']) === false) {
            $dr = BuildSearch::extractDaterange($_GET['pm-dr']);
            echo $dr[0]->format('d.m.') . ' - ' . $dr[1]->format('d.m.Y');
        }
        ?>"/>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" 
        <?php if (!empty($_GET['pm-dr'])) { echo 'style="display: block;"'; } ?>
        class="icon icon-tabler icon-tabler-x datepicker-clear" width="30" height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <line x1="18" y1="6" x2="6" y2="18" />
        <line x1="6" y1="6" x2="18" y2="18" />
    </svg>
</div>