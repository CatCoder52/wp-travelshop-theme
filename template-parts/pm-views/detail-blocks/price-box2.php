<?php

use Pressmind\HelperFunctions;
use Pressmind\Travelshop\PriceHandler;

/**
 * @var array $args
 */

?>
<div class="travelshop-price-box">
    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-check" width="30" height="30"
         viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="#27ae60" stroke-linecap="round"
         stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <circle stroke="#27ae60" cx="12" cy="12" r="9"/>
        <path stroke="#ffffff" d="M9 12l2 2l4 -4"/>
    </svg>
    <div class="col-12">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock" width="20" height="20"
             viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round"
             stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <circle cx="12" cy="12" r="9"/>
            <polyline points="12 7 12 12 15 15"/>
        </svg>
        <?php echo $args['cheapest_price']->duration; ?>
        Tag<?php echo($args['cheapest_price']->duration > 1 ? 'e' : ''); ?>
    </div>
    <div class="col-12">
        <span class="date">
            <a class="show-dates" data-modal="true" data-modal-id="<?php echo $args['id_modal_price_box']; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-event" width="20"
                     height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <rect x="4" y="5" width="16" height="16" rx="2"/>
                    <line x1="16" y1="3" x2="16" y2="7"/>
                    <line x1="8" y1="3" x2="8" y2="7"/>
                    <line x1="4" y1="11" x2="20" y2="11"/>
                    <rect x="8" y="15" width="2" height="2"/>
                </svg>
                <span>
                    <?php echo HelperFunctions::dayNumberToLocalDayName($args['cheapest_price']->date_departure->format('N'), 'short'); ?>.
                    <?php echo $args['cheapest_price']->date_departure->format('d.m.'); ?>
                    -
                    <?php echo HelperFunctions::dayNumberToLocalDayName($args['cheapest_price']->date_arrival->format('N'), 'short'); ?>.
                    <?php echo $args['cheapest_price']->date_arrival->format('d.m.Y'); ?>
                </span>
            </a>
        </span>

    </div>
    <div class="col-12">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-bed" width="20" height="20"
             viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round"
             stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M3 7v11m0 -4h18m0 4v-8a2 2 0 0 0 -2 -2h-8v6"/>
            <circle cx="7" cy="10" r="1"/>
        </svg>
        <div>
            <?php
            echo $args['cheapest_price']->option_name;
            ?><br/>
            <small>
                Belegung:
                <?php
                echo $args['cheapest_price']->option_occupancy . ' ' . ($args['cheapest_price']->option_occupancy > 1 ? 'Personen' : 'Person');
                echo empty($args['cheapest_price']->option_board_type) ? '' : '<br>inkl. ' . $args['cheapest_price']->option_board_type; ?>
            </small>
        </div>
    </div>
    <div class="col-12">
        <?php
        if (($discount = PriceHandler::getDiscount($args['cheapest_price'])) !== false) {
            ?>
            <div class="discount-wrapper">
                <p>
                    <span class="price-total">ab <strong><?php
                            echo PriceHandler::format($args['cheapest_price']->price_total);
                            ?></strong>
                    </span>
                    <span class="msg"><?php echo $discount['name']; ?>
                        <?php
                        if (!empty($discount['valid_to'])) {
                            echo ' bis ' . $discount['valid_to']->format('d.m.');
                        }
                        ?>
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
                    echo PriceHandler::format($args['cheapest_price']->price_total);
                    ?></strong>
            </span>
            <?php
        } ?>
    </div>
    <div class="col-12">
        <a class="btn btn-primary btn-block booking-btn green" data-modal="true" data-modal-id="<?php echo $args['id_modal_price_box']; ?>" target="_blank"
           rel="nofollow">
            zur Buchung
        </a>
    </div>
</div>