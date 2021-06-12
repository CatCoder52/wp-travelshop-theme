<?php

use Pressmind\HelperFunctions;
use Pressmind\Search\CheapestPrice;

/**
 * @var array $args
 */

/**
 * @var Pressmind\ORM\Object\MediaObject $mo
 */
$mo = $args['media_object'];

/**
 * @var Custom\MediaType\Reise $moc
 */
$moc = $mo->getDataForLanguage();

/**
 * @var Pressmind\ORM\Object\Touristic\Booking\Package[] $booking_packages
 */
$booking_packages = $mo->booking_packages;

/**
 * @var Pressmind\ORM\Object\CheapestPriceSpeed $cheapest_price
 */
$cheapest_price = $args['cheapest_price'];

?>
<?php if (!is_null($cheapest_price)) { ?>

    <section class="content-block content-block-detail-booking" id="content-block-detail-booking">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Termine &amp; Preise</h2>

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
                                    ?>

                                    <div class="booking-row no-gutters row booking-row-date">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-check" width="30" height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="#27ae60" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <circle stroke="#27ae60" cx="12" cy="12" r="9" />
                                            <path stroke="#ffffff" d="M9 12l2 2l4 -4" />
                                        </svg>
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
                                            <span class="price">ab <strong><?php
                                                // @TODO use Cheapest Price here
                                                echo number_format($housing_option->price, TS_PRICE_DECIMALS, TS_PRICE_DECIMAL_SEPARATOR,TS_PRICE_THOUSANDS_SEPARATOR);
                                                ?>&nbsp;€</strong></span>
                                        </div>
                                        <div class="col-12 col-lg-2">
                                            <a class="btn btn-primary btn-block booking-btn" target="_blank" rel="nofollow"
                                                href="https://demo.pressmind-ibe.net/?imo=<?php echo $booking_package->id_media_object; ?>&idbp=<?php echo $booking_package->id; ?>&idhp=<?php echo $housing_package->id; ?>&idd=<?php echo $date->id; ?>&iho[<?php echo $housing_option->id; ?>]=1">
                                                zur Buchung
                                            </a>
                                        </div>
                                        <!-- TODO: Add pseudo price
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