<?php
/**
 * @var array $data
 */

/**
 * @var Custom\MediaType\Reise $reise
 */
$reise = $data['data'];

/**
 * @var Pressmind\ORM\Object\Touristic\Booking\Package[] $booking_packages
 */
$booking_packages = $data['booking_packages'];

/**
 * @var Pressmind\ORM\Object\MediaObject $media_object
 */
$media_object = $data['media_object'];

$cheapest_price = $media_object->getCheapestPrice();

$class = empty($data['custom_data']->class) ? 'col-12 col-sm-6 col-lg-3' : $data['custom_data']->class;


/**
 * DON'T USE WordPress Stuff here
 */
?>

<div class="<?php echo $class; ?>">
    <div class="card card-travel">


        <?php
        if (empty($reise->bilder_default[0]) === false) {
            ?>

            <div class="card-image-holder">
                <div class="card-badge card-badge--new">
                    <!--<div class="card-badge card-badge--top-offer">-->
                    Neu
                </div>
                <img src="<?php echo $reise->bilder_default[0]->getUri('teaser'); ?>"
                     title="<?php echo $reise->bilder_default[0]->copyright; ?>"
                     alt="<?php echo $reise->bilder_default[0]->alt; ?>"
                     class="card-img-top"
                     loading="lazy"
                >
            </div>

        <?php } ?>

        <div class="card-body">

            <h5 class="card-title">

                <?php echo $reise->headline_default; ?>
            </h5>
            <p class="attribute-row">
                <?php

                $breadcrumb = array();
                foreach ($reise->reiseart_default as $reiseart_default_item) {
                    $reiseart = $reiseart_default_item->toStdClass();
                    $breadcrumb[] = $reiseart->item->name;
                }

                foreach ($reise->zielgebiet_default as $k => $zielgebiet_default_item) {
                    $zielgebiet = $zielgebiet_default_item->toStdClass();
                    $breadcrumb[] = $zielgebiet->item->name;
                }
                echo '<span class="badge badge-secondary">' . implode('</span> <span class="badge badge-secondary">', $breadcrumb) . '</span>';


                ?>
            </p>

            <?php if(empty($reise->subline_default) === false){?>
            <p class="card-text subline">
                <?php echo strip_tags($reise->subline_default); ?>
                <span class="fade-out"></span>
            </p>

            <?php } ?>


            <p class="card-text price-row">


                <?php
                // cheapest price
                if (empty($cheapest_price->price_option) === false) { ?>
                    <span class="small"><?php
                        echo $cheapest_price->duration . ' Tage Reise<br>';
                        echo $cheapest_price->date_departure->format('d.m') . ' - ' . $cheapest_price->date_arrival->format('d.m.Y');
                        ?></span>
                    <strong class="h5 mt-0 mb-0"><?php
                        echo ' ab ' . number_format($cheapest_price->price_option, 0, ',', '.') . '&nbsp;€';
                        ?>
                    </strong>

                    <?php
                }
                ?>
            </p>

            <?php

            // Build the detail-page link,
            // we add some search values to deliver to customize the offers on the the detail page
            $url = SITE_URL . $media_object->getPrettyUrl();

            // only this search params are transmitted, price range (pm-pr), date range (pm-dr)
            $allowedParams = ['pm-pr', 'pm-dr'];
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
            <a href="<?php echo $url; ?>" class="btn btn-primary stretched-link">Go somewhere</a>
        </div>


    </div>
</div>