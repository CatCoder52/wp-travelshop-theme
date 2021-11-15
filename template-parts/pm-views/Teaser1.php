<?php
use Pressmind\Travelshop\PriceHandler;
/**
 * <code>
 * $args = [
 *  'id_media_object' => 12345
 *  'id_object_type' => 123
 *  'headline' => ''
 *  'subline' => ''
 *  'travel_type' => ''
 *  'destination' => ''
 *  'image' => []
 *  'cheapest_price' => {}
 *  'departure_date_count' => 12
 *  'possible_durations' => []
 *  'dates_per_month' => []
 *  'class' => ''
 * ];
 * </code>
 * @var array $args
 *
 */

/**
 * DON'T USE WordPress Stuff here
 */

// only this search params are transmitted, price range (pm-pr), date range (pm-dr), duration range (pm-du), housingoption occupancy (pm-ho)
$allowedParams = ['pm-pr', 'pm-dr', 'pm-du', 'pm-ho'];
$filteredParams = array_filter($_GET,
    function ($key) use ($allowedParams) {
        return in_array($key, $allowedParams);
    },
    ARRAY_FILTER_USE_KEY
);

if (empty($filteredParams) === false) {
    $query_string = http_build_query($filteredParams);
    $args['url'] .= '?' . $query_string;
}
?>
<article class="<?php echo empty($args['class']) ? 'col-12 col-md-6 col-lg-3' : $args['class']; ?> card-travel-wrapper">
    <div class="card card-travel">
            <div class="card-image-holder col-5 col-sm-5 col-md-12 p-0">
                <div class="card-badge card-badge--new">
                    <!--<div class="card-badge card-badge--top-offer">-->
                    Neu
                </div>
                <div data-pm-id="<?php echo $args['id_media_object']; ?>"
                     data-pm-ot="<?php echo $args['id_object_type']; ?>"
                     data-pm-dr="<?php //echo !is_null($args['cheapest_price']) ? $args['cheapest_price']->date_arrival->format('Ymd') . '-' . $args['cheapest_price']->date_arrival->format('Ymd') : ''; ?>"
                     data-pm-du="<?php //echo !is_null($args['cheapest_price']) ? $args['cheapest_price']->duration : ''; ?>"
                     class="add-to-wishlist">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-heart" width="30"
                         height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="#06f" fill="none"
                         stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path class="wishlist-heart"
                              d="M19.5 13.572l-7.5 7.428l-7.5 -7.428m0 0a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572"/>
                    </svg>
                </div>
                <a href="<?php echo $args['url']; ?>">
                    <?php
                    if (!empty($args['image']['url'])) { ?>
                        <img src="<?php echo $args['image']['url']; ?>"
                             title="<?php echo $args['image']['copyright']; ?>"
                             alt="<?php echo $args['headline']; ?>"
                             width="<?php echo $args['image']['size']['width']; ?>"
                             height="<?php echo $args['image']['size']['height']; ?>"
                             class="card-img-top"
                             loading="lazy">
                    <?php } else { ?>
                        <img src="/placeholder.svg?wh=250x170" class="card-img-top">
                    <?php } ?>
                </a>
            </div>

        <section class="card-body col-7 col-sm-7 col-md-12">

            <h1 class="card-title">
                <a href="<?php echo $args['url']; ?>"><?php echo $args['headline']; ?></a>
            </h1>
            <?php
            $breadcrumb = array_filter([$args['travel_type'], $args['destination'] ?? []]);
            if (!empty($breadcrumb)) { ?>
                <p class="attribute-row">
                    <span class="badge badge-secondary"><?php echo implode('</span> <span class="badge badge-secondary">', $breadcrumb); ?></span>
                </p>
                <?php
            }
            ?>
            <?php if (empty($args['subline']) === false) { ?>
                <p class="card-text subline">
                    <?php echo $args['subline']; ?>
                    <span class="fade-out"></span>
                </p>
            <?php } ?>
            <div class="bottom-aligned">
                <?php
                // cheapest price
                if (empty($args['cheapest_price']->price_total) === false) { ?>
                <div class="card-text date-row">
                    <span class="small">
                        <?php
                        echo '<span>' . $args['cheapest_price']->duration . ' Tage Reise</span><br>';
                        ?>
                    </span>
                        <div class="dropdown">
                            <button class="btn <?php echo $args['departure_date_count'] == 1  || empty($args['dates_per_month']) ? ' disabled' : ' dropdown-toggle'; ?>"
                                    type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                <?php
                                $today = new DateTime();
                                $date_to_format = $args['cheapest_price']->date_departure->format('Y') == $today->format('Y') ? 'd.m.' : 'd.m.Y';
                                echo '<i class="circle green"></i>' .
                                     \Pressmind\HelperFunctions::dayNumberToLocalDayName($args['cheapest_price']->date_departure->format('N'), 'short') . '. ' .
                                     $args['cheapest_price']->date_departure->format('d.m.') . ' - ' .
                                     \Pressmind\HelperFunctions::dayNumberToLocalDayName($args['cheapest_price']->date_arrival->format('N'), 'short') . '. ' .
                                     $args['cheapest_price']->date_arrival->format($date_to_format);
                                /*
                                if($c_dates > 1){
                                    echo '<br><span>'.($c_dates - 1).' weitere'.($c_dates - 1  ==  1? 'r' : '').' Termin'.($c_dates - 1  >  1? 'e' : '').'</span>';
                                }
                                */
                                ?>
                            </button>
                            <?php if ($args['departure_date_count'] > 1 && !empty($args['dates_per_month'])) { ?>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <?php
                                    foreach ($args['dates_per_month'] as $month) {
                                        echo '<p class="dropdown-header">' . \Pressmind\HelperFunctions::monthNumberToLocalMonthName($month['month']) . '</p>';
                                        foreach ($month['five_dates_in_month'] as $date) {
                                                ?>
                                                <a class="dropdown-item<?php //echo ($date->id == $args['cheapest_price']->id_date) ? ' active' : ''; ?>"
                                                   href="<?php echo $args['url']; /* . (!strpos($args['url'], '?') ? '?' : '&') . 'idd=' . $date->id . '&idbp=' . $booking_package->id; */?>">
                                                    <?php

                                                    echo '<i class="circle green"></i>' .
                                                        \Pressmind\HelperFunctions::dayNumberToLocalDayName($date['date_departure']->format('N'), 'short') . '. ' .
                                                        $date['date_departure']->format('d.m.') . ' - ' .
                                                        \Pressmind\HelperFunctions::dayNumberToLocalDayName($date['date_arrival']->format('N'), 'short') . '. ' .
                                                        $date['date_arrival']->format($date_to_format). ' . '.
                                                        $date['duration'].' T ' .
                                                        $date['price_total'];
                                                    ?>
                                                </a>
                                                <?php
                                        }
                                        if ($month['dates_total'] > 5) {
                                            ?>
                                            <a class="dropdown-item" href="<?php echo $args['url']; ?>"><small>mehr Termine
                                                    im <?php echo \Pressmind\HelperFunctions::monthNumberToLocalMonthName($month['month']); ?></small></a>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="card-text price-row">
                        <?php
                        if (($discount = PriceHandler::getDiscount($args['cheapest_price'])) !== false) { ?>
                            <div class="discount-wrapper">
                                <hr>
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
                        ?>
                        <a href="<?php echo $args['url']; ?>" class="travel-teaser-link">
                            <div class="btn btn-primary">
                            <?php
                            echo '<small><span>Preis p.P.</span> <strong>ab</strong> </small><strong>' .PriceHandler::format($args['cheapest_price']->price_total).'</strong>';
                            ?>
                            </div>
                        </a>
                    </div>
                    <?php
                } // if cheapest price is set
                ?>
            </div>
        </section>
    </div>
</article>