<?php
/**
 * This Teaser is used in the following modules:
 *  - template-parts/layout-blocks/product-category-teaser.php
 */
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

$args['class'] = empty($args['class']) ? 'col-12' : $args['class'];

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
<article class="<?php echo $args['class']; ?> card-category-travel-wrapper">

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

        <section class="card-body">

            <h1 class="card-title">
                <a href="<?php echo $args['url']; ?>"><?php echo $args['headline']; ?></a>
            </h1>

            <div class="bottom-aligned">
                <?php
                // cheapest price
                if (empty($args['cheapest_price']->price_total) === false) { ?>
                    <div class="card-text discount-row">
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
                    </div>
                    <div class="card-text price-row">
                        <span class="small">
                            <?php
                            echo '<span>' . $args['cheapest_price']->duration . ' Tage Reise</span><br>';
                            ?>
                        </span>
                        <a href="<?php echo $args['url']; ?>" class="product-price">
                            <?php
                            if (empty($args['cheapest_price']->price_total) === false) {
                                echo '<small><span>Preis p.P.</span> <strong>ab</strong> </small><strong>' . PriceHandler::format($args['cheapest_price']->price_total).'</strong>';
                            } else {
                                ?>zur Reise<?php
                            }
                            ?>
                        </a>
                    </div>
                    <?php
                } // if cheapest price is set
                ?>
            </div>
        </section>
</article>
