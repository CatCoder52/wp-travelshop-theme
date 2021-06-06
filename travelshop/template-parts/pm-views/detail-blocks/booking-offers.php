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

                        <!-- BOOKING_ROW_HEAD: START -->
                        <div class="booking-row no-gutters row booking-row-head d-none d-lg-flex">
                            <div class="col-2">
                                An-/Abreise
                            </div>
                            <div class="col-1">
                                Dauer
                            </div>
                            <div class="col-2">
                                Zimmerart
                            </div>
                            <div class="col-1">
                                Status
                            </div>
                            <div class="col-1">
                                Anzahl
                            </div>
                            <div class="col-2">
                                Preis p.P.
                            </div>
                            <div class="col-2">
                                Gesamtpreis
                            </div>
                        </div>
                        <!-- BOOKING_ROW_HEAD: END -->

                        <?php foreach ($mo->booking_packages as $booking_package) { ?>

                            <?php foreach ($booking_package->dates as $date) { ?>
                                <div class="booking-package">
                                <?php
                                foreach ($date->getHousingOptions() as $key => $housing_option) {
                                    $housing_package = $housing_option->getHousingPackage();
                                    ?>

                                    <!-- BOOKING_ROW_DATE: START -->
                                    <div class="booking-row no-gutters row booking-row-date">
                                        
                                        <?php if($key == 0) { ?>
                                            <div class="col-4 d-lg-none">
                                                <span>An-/Abreise</span>
                                            </div>
                                            <div class="col-8 col-lg-2">

                                                <span class="date">
                                                    <?php // echo HelperFunctions::dayNumberToLocalDayName($date->departure->format('N'), 'short') ?> 
                                                    <?php echo $date->departure->format('d.m.'); ?>
                                                    -
                                                    <?php // echo HelperFunctions::dayNumberToLocalDayName($date->arrival->format('N'), 'short') ?> 
                                                    <?php echo $date->arrival->format('d.m.Y'); ?>
                                                </span>

                                            </div>
                                            <div class="col-4 d-block d-lg-none">
                                                Dauer
                                            </div>
                                            <div class="col-8 col-lg-1">
                                                <?php echo $booking_package->duration; ?>
                                                Tag<?php echo($booking_package->duration > 1 ? 'e' : ''); ?>
                                            </div>
                                        <?php } else { ?>
                                            <div class="d-none d-lg-block col-lg-2"></div>
                                            <div class="d-none d-lg-block col-lg-1"></div>
                                        <?php } ?>
                                        <div class="col-4 d-block d-lg-none">
                                            Zimmerart
                                        </div>
                                        <div class="col-8 col-lg-2">
                                            <?php
                                            echo implode(',', array_filter([$housing_package->name, $housing_option->name, $housing_option->board_type]));
                                            ?>
                                        </div>
                                        <div class="col-4 d-block d-lg-none text-nowrap">
                                            Status
                                        </div>
                                        <div class="col-8 col-lg-1">
                                            <span class="badge badge-success">Buchbar</span>
                                        </div>
                                        <div class="col-4 d-block d-lg-none">
                                            Anzahl
                                        </div>
                                        <div class="col-8 col-lg-1">
                                            <select 
                                                class="booking-housing-count"
                                                data-price="<?php echo $housing_option->price; ?>"
                                                data-imo="<?php echo $booking_package->id_media_object; ?>"
                                                data-idbp="<?php echo $booking_package->id; ?>"
                                                data-idhp="<?php echo $housing_package->id; ?>"
                                                data-idd="<?php echo $date->id; ?>"
                                                data-iho="<?php echo $housing_option->id; ?>"
                                                data-occ="<?php echo $housing_option->occupancy; ?>">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                        <div class="col-4 d-block d-lg-none text-nowrap">
                                            Preis p.P.
                                        </div>
                                        <div class="col-8 col-lg-2">
                                            <span class="price"><?php
                                                // @TODO use Cheapest Price here
                                                echo HelperFunctions::number_format($housing_option->price);
                                                ?>
                                                €</span>
                                        </div>
                                        <div class="col-4 d-block d-lg-none text-nowrap">
                                            Gesamtpreis
                                        </div>
                                        <div class="col-8 col-lg-2">
                                            <span class="price-total">Anzahl wählen</span>
                                        </div>
                                    </div>
                                    <!-- BOOKING_ROW_DATE: END -->

                                <?php } ?>
                                <div class="booking-cta-area" style="display:none;">
                                    <div class="col-12 col-lg-3">
                                        <span class="booking-total">Anzahl wählen</span>
                                        <a class="btn btn-primary btn-block booking-btn" target="_blank" rel="nofollow"
                                            href="https://demo.pressmind-ibe.net/?imo=<?php echo $booking_package->id_media_object; ?>&idbp=<?php echo $booking_package->id; ?>&idhp=<?php echo $housing_package->id; ?>&idd=<?php echo $date->id; ?>&iho[<?php echo $housing_option->id; ?>]=1">
                                            Jetzt Buchen
                                        </a>
                                    </div>
                                </div>
                                </div>
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