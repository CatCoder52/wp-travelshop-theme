<?php
use Pressmind\Travelshop\Template;

/**
 * <code>
 * $args['cheapest_price'] CheapestPriceSpeed
 * $args['url']
 * </code>
 * @var array $args
 */
?>
<?php
$offer_description = [];
$offer_description[] = $args['cheapest_price']->housing_package_name;
$offer_description[] = $args['cheapest_price']->option_name;
echo implode(', ', array_filter($offer_description));
?>
<br>
<small>
    <?php
    if(!empty($args['cheapest_price']->option_occupancy)){
        echo 'Belegung: '.$args['cheapest_price']->option_occupancy.' Person';
        if ($args['cheapest_price']->option_occupancy > 1) {
            echo 'en';
        }
    }
    ?>
    <?php echo empty($args['cheapest_price']->option_board_type) ? '' : '<br />inkl. ' . $args['cheapest_price']->option_board_type; ?>
    <?php
    echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/transport_type_human_string.php', [
        'prefix' => '<br>',
        'transport_type' => $args['cheapest_price']->transport_type,
    ]);

    if($args['cheapest_price']->transport_type == 'FLUG'){
        if(trim($args['cheapest_price']->transport_1_description) == ($args['cheapest_price']->transport_2_description)){
            echo '<br>Flug ab '.$args['cheapest_price']->transport_1_description;
        }else{
            echo '<br>Flug hin :  '.$args['cheapest_price']->transport_1_description;
            echo '<br>Flug zurück:  '.$args['cheapest_price']->transport_2_description;
        }
    }

    ?>
</small>