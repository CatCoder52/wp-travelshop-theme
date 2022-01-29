<?php
use Pressmind\HelperFunctions;
/**
 * <code>
 * $args['date_departure']
 * $args['date_arrival']
 * $args['date_from_format']
 * $args['date_to_format']
 * </code>
 * @var array $args
 */

$today = new DateTime();
if(empty($args['date_from_format'])){
    $args['date_from_format'] =  $args['date_departure']->format('Y') == $today->format('Y') ? 'd.m.' : 'd.m.Y';
}
if(empty($args['date_to_format'])){
    $args['date_to_format'] = $args['date_departure']->format('Y') == $today->format('Y') ? 'd.m.' : 'd.m.Y';
}

echo HelperFunctions::dayNumberToLocalDayName($args['date_departure']->format('N'), 'short').'. ';
echo $args['date_departure']->format($args['date_from_format']);

if(!empty($args['date_arrival']) && $args['date_departure']->format('d.m.Y') != $args['date_arrival']->format('d.m.Y')){
    echo ' - ';
    echo HelperFunctions::dayNumberToLocalDayName($args['date_arrival']->format('N'), 'short').'. ';
    echo $args['date_arrival']->format($args['date_to_format']);
}