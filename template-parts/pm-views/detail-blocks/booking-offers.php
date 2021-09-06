<?php

use Pressmind\HelperFunctions;
use Pressmind\Search\CheapestPrice;
use Pressmind\Travelshop\PriceHandler;

/**
 * @var array $args
 */

/**
 * @var Pressmind\ORM\Object\MediaObject $mo
 */
$mo = $args['media_object'];

/**
 * @var Pressmind\ORM\Object\CheapestPriceSpeed $cheapest_price
 */
$cheapest_price = $args['cheapest_price'];

?>
<?php if (!is_null($cheapest_price)) { ?>

    <section class="content-block content-block-detail-booking" id="content-block-detail-booking">
        <div class="container">
           <?php // require 'booking-offers-calendar.php'; ?>
           <!--
            <div class="row">
                <div class="col-12">
                    <h2>Termine &amp; Preise</h2>
                </div>
            </div>
            -->
            <div class="row">
                <div class="col-12">
                    <div class="content-block-detail-booking-inner">

                        <div class="booking-row no-gutters row booking-row-head d-none d-lg-flex">
                            <div class="col-2">
                                Dauer
                            </div>
                            <div class="col-3">
                                Zeitraum
                            </div>
                            <div class="col-3">
                                Unterbringung
                            </div>
                            <div class="col-2">
                                Preis pro Person
                            </div>
                        </div>

                        <?php foreach ($mo->booking_packages as $booking_package) { ?>

                            <?php foreach ($booking_package->dates as $date) { ?>

                                <?php
                                foreach ($date->getHousingOptions() as $key => $housing_option) {
                                    $housing_package = $housing_option->getHousingPackage();
                                    $checked = ($cheapest_price->id_option == $housing_option->id && $cheapest_price->id_date == $date->id);
                                    ?>
                                    <div class="booking-row no-gutters row booking-row-date<?php echo $checked ? ' checked' : '';?>">
                                        <?php if($checked){?>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-check" width="30" height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="#27ae60" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <circle stroke="#27ae60" cx="12" cy="12" r="9" />
                                                <path stroke="#ffffff" d="M9 12l2 2l4 -4" />
                                            </svg>
                                        <?php } ?>
                                        <div class="col-12 col-lg-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <circle cx="12" cy="12" r="9" />
                                                <polyline points="12 7 12 12 15 15" />
                                            </svg>
                                            <?php echo $booking_package->duration; ?>
                                            Tag<?php echo($booking_package->duration > 1 ? 'e' : ''); ?>
                                        </div>
                                        <div class="col-12 col-lg-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-event" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <rect x="4" y="5" width="16" height="16" rx="2" />
                                                <line x1="16" y1="3" x2="16" y2="7" />
                                                <line x1="8" y1="3" x2="8" y2="7" />
                                                <line x1="4" y1="11" x2="20" y2="11" />
                                                <rect x="8" y="15" width="2" height="2" />
                                            </svg>
                                            <span class="date">
                                                <?php echo HelperFunctions::dayNumberToLocalDayName($date->departure->format('N'), 'short'); ?>.
                                                <?php echo $date->departure->format('d.m.'); ?>
                                                -
                                                <?php echo HelperFunctions::dayNumberToLocalDayName($date->arrival->format('N'), 'short'); ?>.
                                                <?php echo $date->arrival->format('d.m.Y'); ?>
                                            </span>

                                        </div>
                                        <div class="col-12 col-lg-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-bed" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M3 7v11m0 -4h18m0 4v-8a2 2 0 0 0 -2 -2h-8v6" />
                                                <circle cx="7" cy="10" r="1" />
                                            </svg>
                                            <div>
                                                <?php
                                                echo implode(',', array_filter([$housing_package->name, $housing_option->name]));
                                                ?><br />
                                                <small>
                                                    Belegung: <?php echo $housing_option->occupancy; echo ' Person'; if ($housing_option->occupancy > 1) { echo 'en'; } ?> 

                                                    <?php  echo empty($housing_option->board_type) ? '' : '<br />inkl. '.$housing_option->board_type; ?>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-2 price-container">
                                          <?php

                                            $cheapest_price_filter = new CheapestPrice();
                                            $cheapest_price_filter->id_option = $housing_option->id;
                                            $cheapest_price_filter->id_booking_package = $housing_option->id_booking_package;
                                            $cheapest_price_filter->id_date = $date->id;
                                            $housing_options_cheapest_price = $mo->getCheapestPrice($cheapest_price_filter);

                                            if (($discount = PriceHandler::getDiscount($housing_options_cheapest_price)) !== false) {
                                                ?>
                                                <div class="discount-wrapper">
                                                    <p>
                                                        <span class="price-total">ab <strong><?php
                                                                echo PriceHandler::format($housing_options_cheapest_price->price_total);
                                                                ?></strong>
                                                        </span>
                                                        <span class="msg"><?php echo $discount['name']; ?>
                                                            <?php if(!empty($discount['valid_to'])){
                                                                echo ' bis '.$discount['valid_to']->format('d.m.');
                                                            }?>
                                                        </span>
                                                        <span class="discount-label">
                                                            <span class="price"><?php echo $discount['price_before_discount']; ?></span>
                                                            <span class="discount"><?php echo $discount['price_delta']; ?></span>
                                                        </span>

                                                    </p>
                                                </div>
                                                <?php
                                            }else{
                                                ?>
                                                <span class="price-total">ab <strong><?php
                                                        echo PriceHandler::format($housing_options_cheapest_price->price_total);
                                                        ?></strong>
                                                </span>
                                                <?php
                                            } ?>

                                        </div>
                                        <div class="col-12 col-lg-2">
                                            <a class="btn btn-primary btn-block booking-btn green" target="_blank" rel="nofollow"
                                               href="<?php echo \Pressmind\Travelshop\IB3Tools::get_bookinglink($booking_package->id_media_object, $booking_package->id, $date->id, $housing_package->id);?>"
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="16" height="16" viewBox="0 0 24 24" stroke-width="3" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <polyline points="9 6 15 12 9 18" />
                                                </svg>zur Buchung
                                            </a>
                                        </div>

                                        <!--
                                        <div class="bottom-bar">
                                            <div class="col-12 col-lg-2">
                                                <span>anstatt</span> <strong>649,00 €</strong>
                                            </div>
                                            <div class="col-12 col-lg-2">
                                                <span>EZZ</span> <strong>100,00 €</strong>
                                            </div>
                                        </div>
                                    -->
                                    </div>
                                <?php } ?>
                            <?php } ?>

                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </section>

<?php } else { ?>
    <section>
        <div class="content-block content-block-detail-booking" id="content-block-detail-booking">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <small>Es konnten keine gültigen Termine gefunden werden. Bitte wenden Sie sich an
                            unser Service-Center.</small>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>