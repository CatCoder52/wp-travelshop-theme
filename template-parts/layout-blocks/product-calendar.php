<?php
/**
 * <code>
 *  $args = (
 *          [headline] => Reise-Empfehlungen
 *          [text] => Travel is the movement of people between relatively distant geographical locations, and can involve travel by foot, bicycle, automobile, train, boat, bus, airplane, or other means, with or without luggage, and can be one way or round trip.
 *          [search] => Array
 *                  (
 *                       [pm-ot] => 607
 *                       [pm-view] => Teaser1
 *                       [pm-vi] => 10
 *                       [pm-l] => 0,4
 *                       [pm-o] => price-desc
 *                       [...] => @link ../../docs/readme-querystring-api.md for all parameters
 *                  )
 *      )
 * </code>
 * @var array $args
 */

use Pressmind\Search\CheapestPrice;
/**
 * Get the database and config instance from the pressmind sdk
 */
$db = \Pressmind\Registry::getInstance()->get('db');
$config = \Pressmind\Registry::getInstance()->get('config');


/**
 * if you plan to set different fieldname for each objec type as the media object name,
 * you can specifiy a map like this:
 *
 * $calendar_titles = [
 *   607 => 'headline_default',
 *   608 => 'title_default',
 *   {ID_OBJECT_TYPE} => {FIELDNAME} (see database table objectdata_{ID_OBJECT_TYPE})
 * ];
 */
$calendar_titles = [];

// if we want to display object type specific titles, we habe to build a join for each object type table
$joins = [];
$field_titles = [];
foreach ($config['data']['primary_media_type_ids'] as $id_object_type) {
    if(empty($calendar_titles[$id_object_type])){
        continue;
    }
    $field_titles[] = 'mo'.$id_object_type.'.'.$calendar_titles[$id_object_type];
    $joins[] = 'left join objectdata_' . $id_object_type . ' mo' . $id_object_type . ' on (mo.id = mo' . $id_object_type . '.id_media_object)';

}

$title = 'mo.name';
if(!empty($field_titles)){
    $title = 'concat_ws("", '.implode(',', $field_titles).') as name';
}

$items = $db->fetchAll('select distinct  mo.id, ps.date_departure,
                            id_object_type, '.$title.'
                        from pmt2core_cheapest_price_speed ps
                            left join pmt2core_media_objects mo on (mo.id = ps.id_media_object)
                            ' . implode('', $joins) . '
                        where date_departure > now() order by date_departure limit 500;');

if (count($items) == 0) {
    return;
}

$month = ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];
$weekdays = ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'];

?>
<section class="content-block">
    <div class="row">
        <?php if (!empty($args['headline']) || !empty($args['text'])) { ?>
            <div class="col-12">
                <?php if (!empty($args['headline'])) { ?>
                    <h2 class="mt-0">
                        <?php echo $args['headline']; ?>
                    </h2>
                <?php } ?>
                <?php if (!empty($args['text'])) { ?>
                    <p>
                        <?php echo $args['text']; ?>
                    </p>
                <?php } ?>
            </div>
        <?php } ?>

        <div class="col-12">
            <div class="product-calendar-wrap">
                <?php

                if ( count($items) > 0 ) {

                    // -- Group Items by Month/Year
                    $itemsGroupedByMonth = [];

                    foreach ($items as $item) {
                        $date = new DateTime($item->date_departure);
                        $MediaObjectId = $item->id;

                        if ( !isset($itemsGroupedByMonth[$date->format('m.Y')]) ) {
                            $curMonth = $date->format('n') - 1;
                            $itemsGroupedByMonth[$date->format('m.Y')]['details']['title'] = $month[$curMonth] . ' ' . $date->format('Y');
                        }

                        $itemsGroupedByMonth[$date->format('m.Y')]['items'][] = $item;
                        //echo '<p>'.$item->id. ' - '. $date->format('d.m.Y').' ' . strip_tags($item->name). '</p>';
                        //$moc = new \Pressmind\ORM\Object\MediaObject($item->id);
                        //echo $moc->render('Teaser1', TS_LANGUAGE_CODE);
                    }

                    // -- use Grouped Array to render Items
                    $iterateGroups = 1;

                    foreach ( $itemsGroupedByMonth as $group ) {
                        echo "<div class='product-calendar-group'>";

                        echo "<div class='product-calendar-group--title'>";
                        echo "<h3>" . str_replace(date("Y"), '', $group['details']['title']) . "</h3>";
                        echo "</div>";

                        echo "<div class='product-calendar-group--items'>";

                        // calendar title row
                        ?>
                        <div class="product-calendar-items--title row d-none d-md-flex">
                            <div class="col-3">Reisezeitraum</div>
                            <div class="col-4">Reise</div>
                            <div class="col-2">Dauer</div>
                            <div class="col-3 md-align-right">Preis</div>
                        </div>
                        <?php

                        $iterateItems = 1;

                        foreach ( $group['items'] as $item ) {

                            $date = new DateTime($item->date_departure);
                            $MediaObjectId = $item->id;

                            $CheapestPriceFilter = new CheapestPrice();
                            $CheapestPriceFilter->date_from = $date;
                            $CheapestPriceFilter->date_to = $date;
                            $CheapestPriceFilter->occupancies = [2];

                            $moc = new \Pressmind\ORM\Object\MediaObject($MediaObjectId);
                            $cheapest_price = $moc->getCheapestPrice($CheapestPriceFilter);

                            $today = new DateTime();
                            $date_to_format = $cheapest_price->date_arrival->format('Y') == $today->format('Y') ? 'd.m.' : 'd.m.Y';

                            echo "<div class='product-calendar-group-item row' data-product-item='product-item-".$iterateGroups."-".$iterateItems."'>";
                            ?>
                            <div class="col-12 col-md-3">
                                <div class="arrow--wrapper">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 407.437 407.437" style="enable-background:new 0 0 407.437 407.437;" xml:space="preserve"><polygon points="386.258,91.567 203.718,273.512 21.179,91.567 0,112.815 203.718,315.87 407.437,112.815 "/></svg>

                                    <?php
                                    echo '<i class="circle green"></i>' . $weekdays[$cheapest_price->date_departure->format('w')] . '. ' . $cheapest_price->date_departure->format('d.m.') . ' - ' . $weekdays[$cheapest_price->date_arrival->format('w')] . '. ' . $cheapest_price->date_arrival->format($date_to_format);
                                    ?>
                                </div>

                            </div>
                            <div class="col-12 col-md-4">
                                <strong><?php echo $item->name; ?></strong>
                            </div>
                            <div class="col-6 col-md-2">
                                <?php echo $cheapest_price->duration  . ' Tage'; ?>
                            </div>
                            <div class="col-6 col-md-3 md-align-right">
                                                <span class="price">
                                                    <?php
                                                    if (!empty($cheapest_price->price_option_pseudo) && $cheapest_price->price_option_pseudo > $cheapest_price->price_total) {
                                                        $percent_discount = round((100 / $cheapest_price->price_option_pseudo) * ($cheapest_price->price_option_pseudo - $cheapest_price->price_total));
                                                        ?>
                                                        <div class="discount-wrapper">

                                <p>
                                    <span class="msg">Ihr Vorteil</span>
                                    <span class="discount-label">
                                <span class="price"><?php echo $cheapest_price->price_option_pseudo; ?>&nbsp;€</span>
                                <span class="discount"> -<?php echo $percent_discount; ?>%</span>
                            </span>
                                </p>
                            </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if (empty($cheapest_price->price_total) === false) {
                                                        echo '<small><span>Preis p.P.</span> <strong>ab</strong> </small><strong>' . number_format($cheapest_price->price_total, TS_PRICE_DECIMALS, TS_PRICE_DECIMAL_SEPARATOR, TS_PRICE_THOUSANDS_SEPARATOR) . '&nbsp;€</strong>';
                                                    }
                                                    ?>
                                                </span>
                            </div>
                            <?php
                            echo "</div>";

                            echo "<div class='product-calendar-group-item--product row' data-product-item='product-item-".$iterateGroups."-".$iterateItems."'>";
                            $data = new stdClass();
                            $data->cheapest_price = $cheapest_price;
                            echo $moc->render('Teaser5', TS_LANGUAGE_CODE, $data);
                            echo "</div>";

                            $iterateItems++;

                        }

                        echo "</div>";

                        echo "</div>";

                        $iterateGroups++;
                    }

                } else {
                    print_r('Keine Reisen gefunden.');
                }

                ?>
            </div>

        </div>
    </div>
</section>