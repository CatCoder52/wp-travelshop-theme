<?php

use Pressmind\HelperFunctions;
use Pressmind\Search\CheapestPrice;

/**
 * @var array $args
 */

/**
 * @var Custom\MediaType\Reise $moc
 */
$moc = $args['data'];

/**
 * @var Pressmind\ORM\Object\Touristic\Booking\Package[] $booking_packages
 */
$booking_packages = $args['booking_packages'];

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
            <div class="row">
                <div class="col-12">
                    <h2>Termine & Buchung</h2>

                    <div class="content-block-detail-booking-inner">

                        <!-- BOOKING_ROW_HEAD: START -->
                        <div class="booking-row no-gutters row booking-row-head">
                            <div class="col-3">
                                Termin
                            </div>
                            <div class="col-2">
                                Code
                            </div>
                            <div class="col-2">
                                Info
                            </div>
                            <div class="col-2">
                                Preis p.P.
                            </div>
                            <div class="col-3"></div>
                        </div>
                        <!-- BOOKING_ROW_HEAD: END -->

                        <?php foreach ($booking_packages as $booking_package) { ?>

                            <!-- BOOKING_ROW_PROGRAMM: START -->
                            <div class="booking-row no-gutters row booking-row-programm">
                                <div class="col-12">
                                    Reisedauer: <?php echo $booking_package->duration; ?>
                                    Tag<?php echo($booking_package->duration > 1 ? 'e' : ''); ?>
                                </div>
                            </div>
                            <!-- BOOKING_ROW_PROGRAMM: END -->


                            <?php foreach ($booking_package->dates as $date) { ?>
                                <?php
                                foreach ($date->getHousingOptions() as $housing_option) {
                                    $housing_package = $housing_option->getHousingPackage();
                                    ?>

                                    <!-- BOOKING_ROW_DATE: START -->
                                    <div class="booking-row no-gutters row booking-row-date">
                                        <div class="col-3">

                                            <?php echo HelperFunctions::dayNumberToLocalDayName($date->departure->format('N'), 'short') ?> <?php echo $date->departure->format('d.m.'); ?>
                                            -
                                            <?php echo HelperFunctions::dayNumberToLocalDayName($date->arrival->format('N'), 'short') ?> <?php echo $date->arrival->format('d.m.Y'); ?>


                                            <span class="badge badge-success">Buchbar</span>


                                        </div>
                                        <div class="col-2">
                                            <?php echo $date->code; ?>
                                        </div>
                                        <div class="col-2">
                                            <?php
                                            echo implode(',', array_filter([$housing_package->name, $housing_option->name, $housing_option->board_type]));
                                            ?>
                                        </div>
                                        <div class="col-2">
                                            <strong class="price"><?php echo HelperFunctions::number_format($housing_option->price); ?>
                                                €</strong>
                                        </div>
                                        <div class="col-3">

                                            <a class="btn btn-outline-primary btn-block"
                                               href="http://my_ibe_url.pressmind-ibe.net/?imo=<?php echo $booking_package->id_media_object; ?>&idbp=<?php echo $booking_package->id; ?>&idhp=<?php echo $housing_package->id; ?>&idd=<?php echo $date->id; ?>&iho[<?php echo $housing_option->id; ?>]=1">

                                                Jetzt Buchen
                                            </a>
                                        </div>
                                    </div>
                                    <!-- BOOKING_ROW_DATE: END -->

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
                            unsere Service-Center.</small>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>