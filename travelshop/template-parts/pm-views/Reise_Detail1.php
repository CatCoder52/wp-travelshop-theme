<?php

global $PMTravelShop;

use Pressmind\HelperFunctions;
use Pressmind\Search\CheapestPrice;


/**
 * @var array $data
 */

/**
 * @var Custom\MediaType\Reise $moc
 */
$moc = $data['data'];

/**
 * @var Pressmind\ORM\Object\Touristic\Booking\Package[] $booking_packages
 */
$booking_packages = $data['booking_packages'];

/**
 * @var Pressmind\ORM\Object\MediaObject $mo
 */
$mo = $data['media_object'];


/**
 * Set the Cheapest Price, based on the current search parameters
 */
$CheapestPriceFilter = null;
if (empty($_GET['pm-dr']) === false) {
    $dateRange = BuildSearch::extractDaterange($_GET['pm-dr']);
    if ($dateRange !== false) {
        $CheapestPriceFilter = new CheapestPrice();
        $CheapestPriceFilter->date_from = $dateRange[0]->format('Y-m-d');
        $CheapestPriceFilter->date_to = $dateRange[1]->format('Y-m-d');
    }
}

$cheapest_price = $mo->getCheapestPrice($CheapestPriceFilter);



?>

    <!-- CONTENT: START -->
    <div class="content-main">
        <div class="container">
            <?php

            $breadcrumb = array();
            $tmp = new stdClass();
            $tmp->name = 'Startseite';
            $tmp->url = site_url();
            $breadcrumb[] = $tmp;


            $breadcrumb_search_url = site_url() . '/' . $PMTravelShop->RouteProcessor->get_url_by_object_type($mo->id_object_type) . '/?pm-o='.$mo->id_object_type;
            foreach ($moc->reiseart_default as $item) {
                $reiseart = $item->toStdClass();
                $tmp = new stdClass();
                $tmp->name = $reiseart->item->name;
                $tmp->url = $breadcrumb_search_url.'&pm-c[reiseart_default]='.$reiseart->item->id;
                $breadcrumb[] = $tmp;
            }


            foreach ($moc->zielgebiet_default as $item) {
                $zielgebiet = $item->toStdClass();
                $tmp = new stdClass();
                $tmp->name = $zielgebiet->item->name;
                $tmp->url = $breadcrumb_search_url.'&pm-c[zielgebiet_default]='.$zielgebiet->item->id;;
                $breadcrumb[] = $tmp;
            }


            $tmp = new stdClass();
            $tmp->name = strip_tags($moc->headline_default);
            $tmp->url = null;
            $breadcrumb[] = $tmp;

            the_breadcrumb(null, null, $breadcrumb);
            ?>

            <!-- CONTENT_SECTION_DETAIL_HEADER: START -->
            <section class="content-block content-block-detail-header">
                <p>
                    <?php

                    $badges = array();
                    foreach ($moc->reiseart_default as $mocart_default_item) {
                        $mocart = $mocart_default_item->toStdClass();
                        $badges[] = $mocart->item->name;
                    }

                    foreach ($moc->zielgebiet_default as $k => $zielgebiet_default_item) {
                        $zielgebiet = $zielgebiet_default_item->toStdClass();
                        $badges[] = $zielgebiet->item->name;
                    }
                    echo '<span class="badge badge-secondary">' . implode('</span> <span class="badge badge-secondary">', $badges) . '</span>';
                    ?>
                </p>
                <h1> <?php echo $moc->headline_default; ?></h1>
                <p class="small"> <?php echo $moc->subline_default; ?></p>
            </section>
            <!-- CONTENT_SECTION_DETAIL_HEADER: END -->

            <!-- CONTENT_SECTION_DETAIL_INFO_GRID: START -->
            <section class="content-block content-block-detail-info-grid">
                <div class="row">
                    <div class="col-12 col-lg-9">

                        <?php
                        // Imagebrowser
                        load_template(get_template_directory() . '/template-parts/pm-views/detail-blocks/image-browser.php', false, $moc->bilder_default);
                        ?>

                        <div class="detail-reise-content">
                            <p>
                                <?php echo $moc->einleitung_default; ?>
                            </p>
                        </div>

                        <?php if (empty($moc->highlights_default) === false) { ?>
                            <div class="detail-reise-content">
                                <div class="row">
                                    <?php if (empty($moc->bilder_default[3]) === false) { ?>
                                        <div class="col-md-6 col-lg-5">
                                            <img class="w-100 h-auto"
                                                 src="<?php echo $moc->bilder_default[3]->getUri('detail'); ?>"
                                                 data-toggle="tooltip"
                                                 data-placement="bottom" data-html="true"
                                                 alt="<?php echo $moc->bilder_default[3]->alt; ?>"
                                                 title="<?php
                                                 $caption = [];
                                                 $caption[] = !empty($moc->bilder_default[3]->caption) ? $moc->bilder_default[3]->caption : '';
                                                 $caption[] = !empty($moc->bilder_default[3]->copyright) ? '<small>' . $moc->bilder_default[3]->copyright . '</small>' : '';
                                                 echo implode('<br>', array_filter($caption));
                                                 ?>"/></div>
                                    <?php } ?>

                                    <div class="col-md-6 col-lg-7">
                                        <h3>Highlights</h3>
                                        <ul class="default-list">
                                            <?php
                                            foreach ($moc->highlights_default as $highlight) {
                                                echo '<li>' . $highlight->item->name . '</li>';
                                            }
                                            ?>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        <?php } ?>


                        <?php if (empty($moc->beschreibung_text_default) === false) { ?>
                            <div class="detail-reise-content">
                                <h3><?php echo $moc->beschreibung_headline_default; ?></h3>
                                <?php
                                // Set the span style to the correct semantic tag, for example h5

                                $style_search = [];
                                $style_search[] = '/<span[^>]*?class="Head_1"[^>]*>(.*?)<\/span>/';
                                $style_replace[] = '<h5>$1</h5>';
                                $style_search[] = '/\<ul\>/';
                                $style_replace[] = '<ul class="default-list">';


                                echo preg_replace($style_search, $style_replace, $moc->beschreibung_text_default);


                                ?>
                            </div>
                        <?php } ?>

                        <?php if (empty($moc->leistungen_default) === false) { ?>
                            <div class="detail-reise-content">
                                <h3><?php echo $moc->leistungen_headline_default; ?></h3>
                                <?php
                                echo str_replace('<ul>', '<ul class="default-list">', $moc->leistungen_default);
                                ?>
                            </div>
                        <?php } ?>

                        <!-- DETAIL_REISE_CONTENT: START -->
                        <div class="detail-reise-content">
                            <div class="row">

                                <?php if (empty($moc->bilder_default[1]) === false) { ?>
                                    <div class="col-md-6 col-lg-5">
                                        <img class="w-100 h-auto"
                                             src="<?php echo $moc->bilder_default[1]->getUri('detail'); ?>"
                                             data-toggle="tooltip"
                                             data-placement="bottom" data-html="true"
                                             alt="<?php echo $moc->bilder_default[1]->alt; ?>"
                                             title="<?php
                                             $caption = [];
                                             $caption[] = !empty($moc->bilder_default[1]->caption) ? $moc->bilder_default[1]->caption : '';
                                             $caption[] = !empty($moc->bilder_default[1]->copyright) ? '<small>' . $moc->bilder_default[1]->copyright . '</small>' : '';
                                             echo implode('<br>', array_filter($caption));
                                             ?>"/></div>
                                <?php } ?>

                                <?php if (empty($moc->unterkunftsbeschreibungen_default) === false) { ?>
                                    <div class="col-md-6 col-lg-7">
                                        <?php
                                        foreach ($moc->unterkunftsbeschreibungen_default as $unterkunft) {
                                            ?>
                                            <h3><?php //echo $unterkunft->headline_default; ?></h3>
                                            <?php //echo $unterkunft->beschreibung_text_default; ?>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>


                        <?php
                        /*
                        foreach($moc->textbaustein_default as $textbaustein){
                            ?>
                            <div class="detail-reise-content" id="reise-hinweis">
                                <h3></h3>

                            </div>
                        <?php
                        }
                        */
                        ?>

                    </div>
                    <div class="col-12 col-lg-3">
                        <!-- DETAIL_PRICE_BOX: START -->
                        <div class="sticky-container">
                            <?php if (empty($cheapest_price) === false) { ?>
                                <div class="detail-price-box">
                                    <div class="price">
                                        <span class="h5 mb-0 mt-0">ab</span> <span
                                                class="h3 mb-0 mt-0"><?php echo number_format($cheapest_price->price_option, 0, ',', '.') . ' €'; ?></span>
                                    </div>
                                    <p class="small mt-2"><?php echo $cheapest_price->option_name; ?> p.P.</p>
                                    <hr>
                                    <div class="h5"><i class="la la-calendar"></i> Reisetermine</div>
                                    <p><?php echo $cheapest_price->date_departure->format('d.m') . ' - ' . $cheapest_price->date_arrival->format('d.m.Y'); ?></p>
                                    <p class="mb-0">
                                    <div class="dropdown dropdown-termine">
                                        <a href="#content-block-detail-booking">
                                            weitere Termine <i class="la la-angle-down"></i>
                                        </a>

                                    </div>
                                    </p>

                                    <!--
                                     <hr>
                                     <p class="mb-0">
                                         <a href="#" class="detail-pdf-download"><i class="la la-download"></i> PDF
                                             Downloaden</a>
                                     </p>
                                    -->
                                </div>
                                <a class="btn btn-primary btn-booking btn-block btn-lg"
                                   href="#content-block-detail-booking">
                                    Termine &amp; Preise
                                </a>
                            <?php } else { ?>
                                <div class="detail-price-box">
                                    <p class="small mt-2">Diese Reise ist zur Zeit nur auf Anfrage buchbar.</p>
                                </div>
                                <a class="btn btn-primary btn-booking btn-block btn-lg"
                                   href="#content-block-detail-booking">
                                    Anfragen
                                </a>
                            <?php } ?>
                        </div>
                        <!-- DETAIL_PRICE_BOX: END -->
                    </div>
                </div>
            </section>
            <?php
            // Detail Booking
            // @todo does not work with scaffolder engine
            load_template(get_template_directory() . '/template-parts/pm-views/detail-blocks/booking-offers.php', false, array_merge($data, array('cheapest_price' => $cheapest_price)));
            ?>
        </div>
    </div>
<?php
// Gallery
load_template(get_template_directory() . '/template-parts/pm-views/detail-blocks/gallery.php', false, $moc->bilder_default);