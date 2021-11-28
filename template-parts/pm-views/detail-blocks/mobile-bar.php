<?php
use Pressmind\HelperFunctions;
use Pressmind\Travelshop\PriceHandler;

/**
 * @var array $args
 */

?>
<div class="travelshop-detail-mobile-bar">

    <div class="container">
        <span class="travelshop-detail-mobile-bar-title"><?php echo $args['headline'] ?></span>
        <p>
            <?php echo $args['cheapest_price']->duration; ?>
            Tag<?php echo($args['cheapest_price']->duration > 1 ? 'e' : ''); ?>
            - ab
            <strong>
                <?php
                echo PriceHandler::format($args['cheapest_price']->price_total);
                ?>
            </strong>
            <?php if (($discount = PriceHandler::getDiscount($args['cheapest_price'])) !== false) { ?>
                <span class="discount-label">
                        <span class="price"><?php echo str_replace('&nbsp;', '', $discount['price_before_discount']); ?></span>
                        <span class="discount"><?php echo $discount['price_delta']; ?></span>
                    </span>
            <?php } ?>
        </p>
        <div class="travelshop-detail-mobile-bar-cta">
            <div class="travelshop-detail-mobile-bar-date">
                        <span class="date">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-event"
                                 width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50"
                                 fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <rect x="4" y="5" width="16" height="16" rx="2"/>
                                <line x1="16" y1="3" x2="16" y2="7"/>
                                <line x1="8" y1="3" x2="8" y2="7"/>
                                <line x1="4" y1="11" x2="20" y2="11"/>
                                <rect x="8" y="15" width="2" height="2"/>
                            </svg>
                            <a class="show-dates" data-modal="true" data-modal-id="<?php echo $args['id_modal_price_box'];?>">
                                <?php echo HelperFunctions::dayNumberToLocalDayName($args['cheapest_price']->date_departure->format('N'), 'short'); ?>.
                                <?php echo $args['cheapest_price']->date_departure->format('d.m.'); ?>
                                -
                                <?php echo HelperFunctions::dayNumberToLocalDayName($args['cheapest_price']->date_arrival->format('N'), 'short'); ?>.
                                <?php echo $args['cheapest_price']->date_arrival->format('d.m.Y'); ?>
                            </a>
                        </span>
            </div>
            <a class="btn btn-primary btn-block booking-btn green" data-modal="true" data-modal-id="<?php echo $args['id_modal_price_box'];?>" target="_blank"
               rel="nofollow">
                zur Buchung
            </a>
        </div>
    </div>
</div>
