<?php
use Pressmind\HelperFunctions;
/**
 * <code>
 * $args['date']
 * </code>
 * @var array $args
 */

$month_title = HelperFunctions::monthNumberToLocalMonthName($args['date']->format('n'));
$month_title .= $args['date']->format('Y') != date('Y') ? ' ' . $args['date']->format('Y') : '';
echo $month_title;