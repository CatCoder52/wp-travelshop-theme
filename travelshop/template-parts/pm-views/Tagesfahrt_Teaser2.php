<?php

// This Teaser is used for the wish-/favlist feature

/**
 * @var array $data
 */

/**
 * @var Pressmind\ORM\Object\MediaObject $mo
 */
$mo = $data['media_object'];

/**
 * @var Custom\MediaType\Tagesfahrt $moc
 */
$moc = $mo->getDataForLanguage(TS_LANGUAGE_CODE);

$cheapest_price = $mo->getCheapestPrice();

/**
 * DON'T USE WordPress Stuff here
 */

    // Build the detail-page link,
    // we add some search values to deliver to customize the offers on the the detail page
    $url = SITE_URL .$mo->getPrettyUrl(TS_LANGUAGE_CODE);

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
<div class="wishlist-item">
    <div class="wishlist-item-image">
        <a href="<?php echo $url; ?>">
            <img 
                src="<?php echo $moc->bilder_default[0]->getUri('teaser'); ?>" 
                alt="<?php echo strip_tags($moc->headline_default); ?>" 
                title="<?php echo $moc->bilder_default[0]->copyright; ?>"    
            />
        </a>
    </div>
    <div class="wishlist-item-data">
        <span class="name">
            <a href="<?php echo $url; ?>"><?php echo $mo->name;?></a>
        </span>
        <span class="price">
            <div data-pm-id="<?php echo $mo->id;?>" class="remove-from-wishlist">entfernen</div>
            <a href="<?php echo $url; ?>"><?php echo ' ab <strong>' . number_format($cheapest_price->price_option, 0, ',', '.') . '&nbsp;€</strong>' ?></a>
        </span>
    </div>
</div>