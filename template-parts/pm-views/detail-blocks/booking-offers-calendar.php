<?php
use Pressmind\HelperFunctions;
use Pressmind\Search\CheapestPrice;

/**
 * @var array $args
 */

/**
 * @var Pressmind\ORM\Object\MediaObject $mo
 */

/**
 * @var Pressmind\ORM\Object\CheapestPriceSpeed $cheapest_price
 */

?>
<div class="row content-block-detail-booking-calendar">
    <div class="col-12">
            <h2>Buchungskalender</h2>
    </div>
    <div class="col-12">
        <div class="booking-calendar-slider">
            <?php

            $today = new DateTime();

            // build a date to best price map

            /**
             * @var \Pressmind\ORM\Object\CheapestPriceSpeed[] $date_to_cheapest_price
             */
            $date_to_cheapest_price = [];
            foreach ($mo->booking_packages as $booking_package) {
                foreach ($booking_package->dates as $date) {
                    $cheapest_price_filter = new CheapestPrice();
                    $cheapest_price_filter->occupancies = [2];
                    $cheapest_price_filter->date_from = $date->departure;
                    $cheapest_price_filter->date_to = $date->departure;
                    $cp = $mo->getCheapestPrice($cheapest_price_filter);
                    // if the date has multiple prices, display only the cheapest
                    if (!empty($date_to_cheapest_price[$date->departure->format('Y-m-j')]) &&
                        $cp->price_total < $date_to_cheapest_price[$date->departure->format('Y-m-j')]->price_total
                    ) {
                        // set the cheapier price
                        $date_to_cheapest_price[$date->departure->format('Y-m-j')] = $cp;
                    } elseif (empty($date_to_cheapest_price[$date->departure->format('Y-m-j')])
                    ){
                        $date_to_cheapest_price[$date->departure->format('Y-m-j')] = $cp;
                    }
                }
            }

            // find the min and max date range
            $from = new DateTime(array_key_first($date_to_cheapest_price));
            $from->modify('first day of this month');
            $to = new DateTime(array_key_last($date_to_cheapest_price));
            $to->modify('first day of next month');

            // display always three month, even if only one or two months have a valid travel date
            $interval = $to->diff($from);
            if ($interval->format('%m') < 3) {
                $add_months = 3 - $interval->format('%m');
                $to->modify('+' . $add_months . ' month');
            }

            // loop trough all months
            foreach (new DatePeriod($from, new DateInterval('P1M'), $to) as $dt) {

                // fill the calendar grid
                $days = array_merge(
                    array_fill(1, $dt->format('N') - 1, ' '),
                    range(1, $dt->format('t')),
                );

                if (count($days) < 35) {
                    $delta = 35 - count($days);
                    $days = array_merge($days, array_fill(1, $delta, ' '));
                }

                ?>
                <div class="calendar-wrapper">
                    <div class="month-name"><?php echo HelperFunctions::monthNumberToLocalMonthName($dt->format('n')).($today->format('Y') != $dt->format('Y') ? $dt->format(' Y')  : ''); ?></div>
                    <ul class="calendar">
                        <?php
                        foreach (range(1, 7) as $day_of_week) {
                            ?>
                            <li class="weekday"><?php echo HelperFunctions::dayNumberToLocalDayName($day_of_week, 'short'); ?></li>
                            <?php
                        }
                        foreach ($days as $day) {
                            $current_date = $dt->format('Y-m-') . $day;
                            if (!empty($date_to_cheapest_price[$current_date])) {
                                ?>
                                <li class="travel-date" title="<?php echo $date_to_cheapest_price[$current_date]->duration.' '.(($date_to_cheapest_price[$current_date]->duration > 1) ? 'Tage' : 'Tag'); ?> - zur Buchung" data-toggle="tooltip"><a href="<?php echo \Pressmind\Travelshop\IB3Tools::get_bookinglink($mo->id, $date_to_cheapest_price[$current_date]->id_booking_package, $date_to_cheapest_price[$current_date]->id_date, $date_to_cheapest_price[$current_date]->id_housing_package);?>"><?php echo $day; ?>
                                        <div>ab&nbsp;<?php
                                            echo number_format($date_to_cheapest_price[$current_date]->price_total, TS_PRICE_DECIMALS, TS_PRICE_DECIMAL_SEPARATOR, TS_PRICE_THOUSANDS_SEPARATOR);
                                            ?>&nbsp;€
                                        </div>
                                    </a></li>
                                <?php
                            } else {
                                ?>
                                <li><?php echo $day; ?></li>
                                <?php
                            }
                        } ?>
                    </ul>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>