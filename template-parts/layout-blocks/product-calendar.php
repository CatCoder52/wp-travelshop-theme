<?php
/**
 * <code>
 *  $args = (
 *          [headline] => Reise-Empfehlungen
 *          [text] => Travel is the movement of people between relatively distant geographical locations, and can involve travel by foot, bicycle, automobile, train, boat, bus, airplane, or other means, with or without luggage, and can be one way or round trip.
 *      )
 * </code>
 * @var array $args
 */

use Pressmind\Search\CheapestPrice;
use Pressmind\HelperFunctions;
use Pressmind\Travelshop\PriceHandler;


/**
 * Get the database and config instance from the pressmind sdk
 */
$db = \Pressmind\Registry::getInstance()->get('db');
$config = \Pressmind\Registry::getInstance()->get('config');


/**
 * if you plan to set different fieldnames for each object type as the media object name,
 * you can specify a map like this:
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
    if (empty($calendar_titles[$id_object_type])) {
        continue;
    }
    $field_titles[] = 'mo' . $id_object_type . '.' . $calendar_titles[$id_object_type];
    $joins[] = 'left join objectdata_' . $id_object_type . ' mo' . $id_object_type . ' on (mo.id = mo' . $id_object_type . '.id_media_object)';

}

$title = 'mo.name';
if (!empty($field_titles)) {
    $title = 'concat_ws("", ' . implode(',', $field_titles) . ') as name';
}

$items = $db->fetchAll('select distinct  mo.id, ps.date_departure,
                            id_object_type, ' . $title . '
                        from pmt2core_cheapest_price_speed ps
                            left join pmt2core_media_objects mo on (mo.id = ps.id_media_object)
                            ' . implode('', $joins) . '
                        where date_departure > now() order by date_departure limit 500;');

// abort if nothing to display
if (count($items) == 0) {
    return;
}


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
                // -- Group Items by Month/Year
                $itemsGroupedByMonth = [];
                foreach ($items as $item) {
                    $item->date_departure = new DateTime($item->date_departure);
                    $itemsGroupedByMonth[$item->date_departure->format('m.Y')][] = $item;
                }

                // -- use Grouped Array to render Items
                $month_count = 1;
                foreach ($itemsGroupedByMonth as $items) { ?>
                    <div class="product-calendar-group">

                        <div class="product-calendar-group--title">
                            <h3><?php
                                echo HelperFunctions::monthNumberToLocalMonthName($items[0]->date_departure->format('n'));
                                echo $items[0]->date_departure->format('Y') != date('Y') ? ' '.$items[0]->date_departure->format('Y') : '';
                                ?>
                            </h3>
                        </div>

                        <div class="product-calendar-group--items">
                            <div class="product-calendar-items--title row d-none d-md-flex">
                                <div class="col-3">Reisezeitraum</div>
                                <div class="col-4">Reise</div>
                                <div class="col-2">Dauer</div>
                                <div class="col-3 md-align-right">Preis</div>
                            </div>
                            <?php

                            $date_count = 1;
                            foreach ($items as $item) {

                                $CheapestPriceFilter = new CheapestPrice();
                                $CheapestPriceFilter->date_from = $CheapestPriceFilter->date_to = $item->date_departure;
                                $CheapestPriceFilter->occupancies = [2];

                                $mo = new \Pressmind\ORM\Object\MediaObject($item->id);
                                $cheapest_price = $mo->getCheapestPrice($CheapestPriceFilter);

                                ?>
                                <div class="product-calendar-group-item row"
                                     data-product-item="product-item-<?php echo $month_count . "-" . $date_count; ?>">

                                    <div class="col-12 col-md-3">
                                        <div class="arrow--wrapper">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink"
                                                 x="0px" y="0px" viewBox="0 0 407.437 407.437"
                                                 style="enable-background:new 0 0 407.437 407.437;"
                                                 xml:space="preserve">
                                        <polygon
                                                points="386.258,91.567 203.718,273.512 21.179,91.567 0,112.815 203.718,315.87 407.437,112.815 "/>
                                    </svg>
                                            <i class="circle green"></i>
                                            <?php
                                            echo HelperFunctions::dayNumberToLocalDayName($cheapest_price->date_departure->format('N'), 'short').'. ';
                                            echo $cheapest_price->date_departure->format('d.m.');
                                            echo ' - ';
                                            echo HelperFunctions::dayNumberToLocalDayName($cheapest_price->date_arrival->format('N'), 'short').'. ';
                                            echo $cheapest_price->date_arrival->format('d.m.');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <strong><?php echo $item->name;?></strong>
                                    </div>
                                    <div class="col-6 col-md-2">
                                        <?php echo $cheapest_price->duration . ' Tage'; ?>
                                    </div>
                                    <div class="col-6 col-md-3 md-align-right">
                                        <span class="price">
                                            <?php
                                            if (($discount = PriceHandler::getDiscount($cheapest_price)) !== false) {
                                                ?>
                                                <div class="discount-wrapper">
                                                    <p>
                                                        <span class="msg"><?php echo $discount['name']; ?></span>
                                                        <span class="discount-label">
                                                            <span class="price"><?php echo $discount['price_before_discount']; ?></span>
                                                            <span class="discount"><?php echo $discount['price_delta']; ?></span>
                                                        </span>
                                                    </p>
                                                </div>
                                                <?php
                                            }
                                            if (empty($cheapest_price->price_total) === false) {
                                                echo '<small><span>Preis p.P.</span> <strong>ab</strong> </small><strong>' . PriceHandler::format($cheapest_price->price_total). '</strong>';
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="product-calendar-group-item--product row"
                                     data-product-item="product-item-<?php echo $month_count . "-" . $date_count; ?>">
                                    <?php
                                    $data = new stdClass();
                                    $data->cheapest_price = $cheapest_price;
                                    echo $mo->render('Teaser5', TS_LANGUAGE_CODE, $data);
                                    ?>
                                </div>
                                <?php
                                $date_count++;
                            } // each item
                            ?>
                        </div>
                    </div>
                    <?php
                    $month_count++;
                } // each month
                ?>
            </div>
        </div>
    </div>
</section>