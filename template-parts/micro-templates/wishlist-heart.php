<?php
use Pressmind\Travelshop\IB3Tools;
/**
 * <code>
 * $args['cheapest_price'] CheapestPriceSpeed
 * $args['id_media_object']
 * $args['id_object_type']
 * </code>
 * @var array $args
 */
?>
<div data-pm-id="<?php echo $args['id_media_object']; ?>"
     data-pm-ot="<?php echo $args['id_object_type']; ?>"
     data-pm-dr="<?php echo !is_null($args['cheapest_price']) ? $args['cheapest_price']->date_arrival->format('Ymd') . '-' . $args['cheapest_price']->date_arrival->format('Ymd') : ''; ?>"
     data-pm-du="<?php echo !is_null($args['cheapest_price']) ? $args['cheapest_price']->duration : ''; ?>"
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