<?php

use Pressmind\HelperFunctions;
use Pressmind\Search\CheapestPrice;
use Pressmind\Travelshop\PriceHandler;

/**
 * @var array $args
 */

$filter = new CheapestPrice();
$filter->occupancies_disable_fallback = false;

/**
 * @var \Pressmind\ORM\Object\CheapestPriceSpeed[] $offers
 */
$offers = $args['media_object']->getCheapestPrices($filter, ['date_departure' => 'ASC', 'price_total' => 'ASC'], [0, 100]);

if (!empty($offers)) { ?>

    <section class="content-block content-block-detail-booking" id="content-block-detail-booking">
        <div class="container">
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

                        <?php
                        foreach ($offers as $offer) {

                            //$housing_package = $housing_option->getHousingPackage();

                            $checked = ($args['cheapest_price']->id_option == $offer->id_option && $args['cheapest_price']->id_date == $offer->id_date);
                            ?>
                            <div class="booking-row no-gutters row booking-row-date<?php echo $checked ? ' checked' : ''; ?>">
                                <?php if ($checked) { ?>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="icon icon-tabler icon-tabler-circle-check" width="30" height="30"
                                         viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="#27ae60"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <circle stroke="#27ae60" cx="12" cy="12" r="9"/>
                                        <path stroke="#ffffff" d="M9 12l2 2l4 -4"/>
                                    </svg>
                                <?php } ?>
                                <div class="col-12 col-lg-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock"
                                         width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50"
                                         fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <circle cx="12" cy="12" r="9"/>
                                        <polyline points="12 7 12 12 15 15"/>
                                    </svg>
                                    <?php echo $offer->duration; ?>
                                    Tag<?php echo($offer->duration > 1 ? 'e' : ''); ?>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="icon icon-tabler icon-tabler-calendar-event" width="20" height="20"
                                         viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <rect x="4" y="5" width="16" height="16" rx="2"/>
                                        <line x1="16" y1="3" x2="16" y2="7"/>
                                        <line x1="8" y1="3" x2="8" y2="7"/>
                                        <line x1="4" y1="11" x2="20" y2="11"/>
                                        <rect x="8" y="15" width="2" height="2"/>
                                    </svg>
                                    <span class="date">
                                                <?php echo HelperFunctions::dayNumberToLocalDayName($offer->date_departure->format('N'), 'short'); ?>.
                                                <?php echo $offer->date_departure->format('d.m.'); ?>
                                                -
                                                <?php echo HelperFunctions::dayNumberToLocalDayName($offer->date_arrival->format('N'), 'short'); ?>.
                                                <?php echo $offer->date_arrival->format('d.m.Y'); ?>
                                            </span>

                                </div>
                                <div class="col-12 col-lg-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-bed"
                                         width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50"
                                         fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M3 7v11m0 -4h18m0 4v-8a2 2 0 0 0 -2 -2h-8v6"/>
                                        <circle cx="7" cy="10" r="1"/>
                                    </svg>
                                    <div>
                                        <?php
                                        $offer_description = [];
                                        $offer_description[] = $offer->option_name;

                                        //$offer_description[] = $housing_package->name; // TODO

                                        if($offer->transport_type == 'FLUG'){
                                            if(trim($offer->transport_1_description) == ($offer->transport_2_description)){
                                                $offer_description[] = 'Flug ab '.$offer->transport_1_description;
                                            }else{
                                                $offer_description[] = 'Flughafen hin :  '.$offer->transport_1_description;
                                                $offer_description[] = 'Flughafen zurück:  '.$offer->transport_2_description;
                                            }

                                        }
                                        echo implode(', ', array_filter($offer_description));
                                        ?>
                                        <br>
                                        <small>
                                            Belegung: <?php echo $offer->option_occupancy;
                                            echo ' Person';
                                            if ($offer->option_occupancy > 1) {
                                                echo 'en';
                                            } ?>

                                            <?php echo empty($offer->option_board_type) ? '' : '<br />inkl. ' . $offer->option_board_type; ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-2 price-container">
                                    <?php

                                    if (($discount = PriceHandler::getDiscount($offer)) !== false) {
                                        ?>
                                        <div class="discount-wrapper">
                                            <p>
                                                        <span class="price-total">ab <strong><?php
                                                                echo PriceHandler::format($offer->price_total);
                                                                ?></strong>
                                                        </span>
                                                <span class="msg"><?php echo $discount['name']; ?>
                                                    <?php if (!empty($discount['valid_to'])) {
                                                        echo ' bis ' . $discount['valid_to']->format('d.m.');
                                                    } ?>
                                                        </span>
                                                <span class="discount-label">
                                                            <span class="price"><?php echo $discount['price_before_discount']; ?></span>
                                                            <span class="discount"><?php echo $discount['price_delta']; ?></span>
                                                        </span>

                                            </p>
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <span class="price-total">ab <strong><?php
                                                echo PriceHandler::format($offer->price_total);
                                                ?></strong>
                                                </span>
                                        <?php
                                    } ?>

                                </div>
                                <div class="col-12 col-lg-2">
                                    <a class="btn btn-primary btn-block booking-btn green" target="_blank"
                                       rel="nofollow"
                                       href="<?php echo \Pressmind\Travelshop\IB3Tools::get_bookinglink($offer->id_media_object, $offer->id_booking_package, $offer->id_date, $offer->id_housing_package, null, $args['url']); ?>"
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="icon icon-tabler icon-tabler-chevron-right" width="16" height="16"
                                         viewBox="0 0 24 24" stroke-width="3" stroke="#ffffff" fill="none"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <polyline points="9 6 15 12 9 18"/>
                                    </svg>
                                    zur Buchung
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