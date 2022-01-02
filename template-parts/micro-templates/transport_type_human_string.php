<?php
/**
 * <code>
 * $args['prefix']
 * $args['transport_type']
 * </code>
 * @var array $args
 */

$map = [
'BUS' => 'Busreise',
'FLUG' => 'Flugreise',
'PKW' => 'PKW-Reise',
];
if(isset($map[$args['transport_type']])){
    echo !empty($args['prefix']) ? $args['prefix'] : '';
    echo $map[$args['transport_type']];
}