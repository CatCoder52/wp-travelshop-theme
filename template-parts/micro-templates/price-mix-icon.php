<?php
/**
 * <code>
 * $args['price_mix']
 * </code>
 * @var array $args
 */
?>
<?php if($args['price_mix'] == 'date_housing'){?>
    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-bed"
         width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50"
         fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <path d="M3 7v11m0 -4h18m0 4v-8a2 2 0 0 0 -2 -2h-8v6"/>
        <circle cx="7" cy="10" r="1"/>
    </svg>
<?php }elseif($args['price_mix'] == 'date_ticket'){?>
    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ticket" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50"
         fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <line x1="15" y1="5" x2="15" y2="7" />
        <line x1="15" y1="11" x2="15" y2="13" />
        <line x1="15" y1="17" x2="15" y2="19" />
        <path d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2" />
    </svg>
<?php }else{ ?>
    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-star" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50"
         fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
    </svg>
<?php } ?>