<?php
use Pressmind\Travelshop\IB3Tools;
/**
 * <code>
 * $args['cheapest_price'] CheapestPriceSpeed
 * $args['url']
 * $args['modal_id']
 * </code>
 * @var array $args
 */
?>
<a class="btn btn-primary btn-block booking-btn green" target="_blank"
   rel="nofollow"
   <?php
   if(!empty($args['modal_id'])){
       echo 'data-modal="true" data-modal-id="'.$args['modal_id'].'"';
   }
   ?>
   href="<?php echo IB3Tools::get_bookinglink($args['cheapest_price'], $args['url']); ?>">
    <svg xmlns="http://www.w3.org/2000/svg"
         class="icon icon-tabler icon-tabler-chevron-right" width="16" height="16"
         viewBox="0 0 24 24" stroke-width="3" stroke="#ffffff" fill="none"
         stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <polyline points="9 6 15 12 9 18"/>
    </svg>
    zur Buchung
</a>