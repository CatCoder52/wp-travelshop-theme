<?php
use Pressmind\HelperFunctions;
use Pressmind\Travelshop\Template;

/**
 * <code>
 * $args['date_departure']
 * $args['date_arrival']
 * $args['dates_per_month']
 * $args['departure_date_count']
 * $args['url']
 * </code>
 * @var array $args
 */

$today = new DateTime();
$date_to_format = $args['date_departure']->format('Y') == $today->format('Y') ? 'd.m.' : 'd.m.Y';
?>
<div class="dropdown">
    <button class="btn <?php echo $args['departure_date_count'] == 1  || empty($args['dates_per_month']) ? ' disabled' : ' dropdown-toggle'; ?>"
            type="button"
            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
        <?php
        echo '<i class="circle green"></i>';
        echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/travel-date-range.php', [
            'date_departure' => $args['date_departure'],
            'date_arrival' => $args['date_arrival'],
            'date_to_format ' => $date_to_format
        ]);
        ?>
    </button>
    <?php if ($args['departure_date_count'] > 1 && !empty($args['dates_per_month'])) { ?>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <?php
            foreach ($args['dates_per_month'] as $month) {
                echo '<p class="dropdown-header">' . HelperFunctions::monthNumberToLocalMonthName($month['month']) . '</p>';
                foreach ($month['five_dates_in_month'] as $date) {
                    ?>
                    <a class="dropdown-item<?php //echo ($date->id == $args['cheapest_price']->id_date) ? ' active' : ''; ?>"
                       href="<?php echo $args['url']; /* . (!strpos($args['url'], '?') ? '?' : '&') . 'idd=' . $date->id . '&idbp=' . $booking_package->id; */?>">
                        <?php
                        echo '<i class="circle green"></i>';
                        echo Template::render(APPLICATION_PATH.'/template-parts/micro-templates/travel-date-range.php', [
                            'date_departure' => $date['date_departure'],
                            'date_arrival' => $date['date_arrival'],
                            'date_to_format ' => $date_to_format
                        ]);
                        ?>
                    </a>
                    <?php
                }
                if ($month['dates_total'] > 5) {
                    ?>
                    <a class="dropdown-item" href="<?php echo $args['url']; ?>"><small>mehr Termine
                            im <?php echo HelperFunctions::monthNumberToLocalMonthName($month['month']); ?></small></a>
                    <?php
                }
            }
            ?>
        </div>
    <?php } ?>
</div>

