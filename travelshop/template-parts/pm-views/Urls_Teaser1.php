<?php
/**
 * @var array $data
 */

/**
 * @var Pressmind\ORM\Object\MediaObject $mo
 */

use Pressmind\Search\CheapestPrice;

$mo = $data['media_object'];

/**
 * @var Custom\MediaType\Urls $moc
 */
$moc = $mo->getDataForLanguage(TS_LANGUAGE_CODE);

/**
 * Set the Cheapest Price, based on the current search parameters
 */

$CheapestPriceFilter = new CheapestPrice();

if (empty($_GET['pm-dr']) === false) {
    $dateRange = BuildSearch::extractDaterange($_GET['pm-dr']);
    if ($dateRange !== false) {
        $CheapestPriceFilter->date_from = $dateRange[0];
        $CheapestPriceFilter->date_to = $dateRange[1];
    }
}

if (empty($_GET['pm-du']) === false) {
    $durationRange = BuildSearch::extractDurationRange($_GET['pm-du']);
    if ($durationRange !== false) {
        $CheapestPriceFilter->duration_from = $durationRange[0];
        $CheapestPriceFilter->duration_to = $durationRange[1];
    }
}


if (empty($_GET['pm-pr']) === false) {
    $priceRange = BuildSearch::extractPriceRange($_GET['pm-pr']);
    if ($priceRange !== false) {
        $CheapestPriceFilter->price_from = $priceRange[0];
        $CheapestPriceFilter->price_to = $priceRange[1];
    }
}

$CheapestPriceFilter->occupancies = [2];

$cheapest_price = $mo->getCheapestPrice($CheapestPriceFilter);


$class = empty($data['custom_data']->class) ? 'col-12 col-md-6 col-lg-3' : $data['custom_data']->class;

/**
 * DON'T USE WordPress Stuff here
 */
?>

<?php
    // Build the detail-page link,
    // we add some search values to deliver to customize the offers on the the detail page
    $url = SITE_URL .$mo->getPrettyUrl(TS_LANGUAGE_CODE);

    // only this search params are transmitted, price range (pm-pr), date range (pm-dr), duration range (pm-du), housingoption occupancy (pm-ho)
    $allowedParams = ['pm-pr', 'pm-dr', 'pm-du', 'pm-ho'];
    $filteredParams = array_filter($_GET,
        function ($key) use ($allowedParams) {
            return in_array($key, $allowedParams);
        },
        ARRAY_FILTER_USE_KEY
    );

    if(empty($filteredParams) === false){
        $query_string = http_build_query($filteredParams);
        $url .= '?'.$query_string;
    }
?>

<div class="<?php echo $class; ?> card-travel-wrapper">
    <div class="card card-travel">

        <div class="container">

        <div class="row">

        <?php
        if (empty($moc->bilder_default[0]) === false) {
            ?>

            <div class="card-image-holder col-4 col-sm-5 col-md-12 p-0">
                <div class="card-badge card-badge--new">
                    <!--<div class="card-badge card-badge--top-offer">-->
                    Neu
                </div>
                <div data-pm-id="<?php echo $mo->id; ?>"
                     data-pm-ot="<?php echo $mo->id_object_type; ?>"
                     data-pm-dr="<?php echo !is_null($cheapest_price) ? $cheapest_price->date_arrival->format('Ymd').'-'.$cheapest_price->date_arrival->format('Ymd') : ''; ?>"
                     data-pm-du="<?php echo !is_null($cheapest_price) ? $cheapest_price->duration : ''; ?>"
                     class="add-to-wishlist">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-heart" width="30" height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="#06f" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path class="wishlist-heart" d="M19.5 13.572l-7.5 7.428l-7.5 -7.428m0 0a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                    </svg>
                </div>
                <a href="<?php echo $url; ?>">
                    <img src="<?php echo $moc->bilder_default[0]->getUri('teaser'); ?>"
                        title="<?php echo $moc->bilder_default[0]->copyright; ?>"
                        alt="<?php echo strip_tags($moc->headline_default); ?>"
                        class="card-img-top"
                        loading="lazy"
                    >
                </a>
            </div>

        <?php } ?>

        <div class="card-body col-8 col-sm-7 col-md-12">

            <h5 class="card-title">
                <a href="<?php echo $url; ?>"><?php echo strip_tags($moc->headline_default); ?></a>
            </h5>
                <?php
                    $breadcrumb = array();

                    if(!empty($moc->reiseart_default)){
                        foreach ($moc->reiseart_default as $mocart_default_item) {
                            $mocart = $mocart_default_item->toStdClass();
                            $breadcrumb[] = $mocart->item->name;
                        }
                    }

                    if(!empty($moc->zielgebiet_default)){
                        foreach ($moc->zielgebiet_default as $k => $zielgebiet_default_item) {
                            $zielgebiet = $zielgebiet_default_item->toStdClass();
                            $breadcrumb[] = $zielgebiet->item->name;
                        }
                    }

                    if(!empty($breadcrumb)){?>
                        <p class="attribute-row">
                           <span class="badge badge-secondary"><?php echo implode('</span> <span class="badge badge-secondary">', $breadcrumb);?></span>
                        </p>
                    <?php
                    }
                ?>


            <?php if(empty($moc->subline_default) === false){?>
            <p class="card-text subline">
                <?php echo strip_tags($moc->subline_default); ?>
                <span class="fade-out"></span>
            </p>

            <?php } ?>




            <div class="bottom-aligned">

                <?php

                $c_dates = 0;
                foreach($mo->booking_packages as $booking_package){
                    $c_dates += count($booking_package->dates);
                }

                // cheapest price
                if (empty($cheapest_price->price_option) === false) {

                    $month = ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];
                    $weekdays = ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'];

                    ?>


                    <div class="card-text date-row">

                         <span class="small">
                            <?php
                                echo '<span>' . $cheapest_price->duration . ' Tage Reise</span><br>';
                            ?>
                        </span>

                        <div class="dropdown">
                            <button class="btn <?php echo $c_dates == 1 ? ' disabled' : ' dropdown-toggle';?>" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php

                                $today = new DateTime();
                                $date_to_format = $cheapest_price->date_arrival->format('Y') == $today->format('Y')  ? 'd.m.' : 'd.m.Y';

                                echo '<i class="circle green"></i>'.$weekdays[$cheapest_price->date_departure->format('w')].'. '.$cheapest_price->date_departure->format('d.m.') . ' - ' .$weekdays[$cheapest_price->date_arrival->format('w')].'. '. $cheapest_price->date_arrival->format($date_to_format);
                                /*
                                if($c_dates > 1){
                                    echo '<br><span>'.($c_dates - 1).' weitere'.($c_dates - 1  ==  1? 'r' : '').' Termin'.($c_dates - 1  >  1? 'e' : '').'</span>';
                                }
                                */

                                ?>
                            </button>
                            <?php if($c_dates > 1){?>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <?php

                                foreach($mo->booking_packages as $booking_package){
                                    if($booking_package->id != $cheapest_price->id_booking_package){
                                        continue;
                                    }

                                    $current_month = null;
                                    $c = 0;
                                    foreach($booking_package->dates as $date){
                                        if($current_month != $month[$date->departure->format('n')-1]){
                                            $current_month = $month[$date->departure->format('n')-1];
                                            $c = 0;
                                            echo '<p class="dropdown-header">'.$current_month.'</p>';
                                        }

                                        if($c < 5){ // display only 5 dates per month ?>
                                            <a class="dropdown-item<?php echo ($date->id == $cheapest_price->id_date) ? ' active' : '';?>" href="<?php echo $url.(!strpos($url, '?') ? '?' : '&').'idd='.$date->id.'&idbp='.$booking_package->id;?>">
                                                <?php
                                                echo '<i class="circle green"></i>'.$weekdays[$date->departure->format('w')].'. '. $date->departure->format('d.m.') . ' - '.$weekdays[$date->arrival->format('w')].'. '. $date->arrival->format($date_to_format);
                                                ?>
                                            </a>
                                            <?php
                                                }else{
                                            ?>
                                            <a class="dropdown-item" href="<?php echo $url;?>"><small>mehr Termine im <?php echo $current_month; ?></small></a>
                                        <?php
                                            continue;
                                        }
                                        $c++;
                                    }
                                }
                                ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="card-text price-row">
                        <?php
                        if(!empty($cheapest_price->price_option_pseudo) && $cheapest_price->price_option_pseudo > $cheapest_price->price_total){
                            $percent_discount = round((100 / $cheapest_price->price_option_pseudo) * ($cheapest_price->price_option_pseudo - $cheapest_price->price_total));
                         ?>
                            <div class="discount-wrapper">
                                <hr>
                                <p>
                                    <span class="msg">Ihr Vorteil</span>
                                    <span class="discount-label">
                                        <span class="price"><?php echo $cheapest_price->price_option_pseudo; ?>&nbsp;€</span>
                                        <span class="discount"> -<?php echo $percent_discount;?>%</span>
                                    </span>
                                </p>
                            </div>
                            <?php
                        }
                        ?>
                        <a href="<?php echo $url; ?>" class="btn btn-primary">
                            <?php
                            if (empty($cheapest_price->price_total) === false) {
                                echo '<small><span>Preis p.P.</span> <strong>ab</strong> </small><strong>' . number_format($cheapest_price->price_total, 0, ',', '.') . '&nbsp;€</strong>';
                            }else{
                                ?>zur Reise<?php
                            }
                            ?>
                        </a>
                    </div>
                    <?php
                } // if cheapest price is set
                ?>
            </div>


        </div>

        </div>

        </div>

    </div>
</div>