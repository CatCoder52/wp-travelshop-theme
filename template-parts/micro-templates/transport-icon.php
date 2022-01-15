<?php
/**
 * <code>
 * $args['transport_type']
 * </code>
 * @var array $args
 */
?>
<?php if($args['transport_type'] == 'FLUG'){ ?>
    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plane" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <path d="M16 10h4a2 2 0 0 1 0 4h-4l-4 7h-3l2 -7h-4l-2 2h-3l2 -4l-2 -4h3l2 2h4l-2 -7h3z" />
    </svg>
<?php }elseif($args['transport_type'] == 'BUS'){ ?>
    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-bus" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <circle cx="6" cy="17" r="2" />
        <circle cx="18" cy="17" r="2" />
        <path d="M4 17h-2v-11a1 1 0 0 1 1 -1h14a5 7 0 0 1 5 7v5h-2m-4 0h-8" />
        <polyline points="16 5 17.5 12 22 12" />
        <line x1="2" y1="10" x2="17" y2="10" />
        <line x1="7" y1="5" x2="7" y2="10" />
        <line x1="12" y1="5" x2="12" y2="10" />
    </svg>
<?php }elseif($args['transport_type'] == 'PKW'){ ?>
    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-car" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <circle cx="7" cy="17" r="2" />
        <circle cx="17" cy="17" r="2" />
        <path d="M5 17h-2v-6l2 -5h9l4 5h1a2 2 0 0 1 2 2v4h-2m-4 0h-6m-6 -6h15m-6 0v-5" />
    </svg>
<?php }else{ ?>
    <svg xmlns="http://www.w3.org/2000/svg"
         class="icon icon-tabler icon-tabler-calendar-event" width="20" height="20"
         viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none"
         stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <rect x="4" y="5" width="16" height="16" rx="2"/>
        <line x1="16" y1="3" x2="16" y2="7"/>
        <line x1="8" y1="3" x2="8" y2="7"/>
        <line x1="4" y1="11" x2="20" y2="11"/>
        <rect x="8" y="15" width="2" height="2"/>
    </svg>
<?php } ?>