<?php
/**
 * <code>
 *  $args = (
 *          [headline] => Reise-Empfehlungen
 *          [text] => Travel is the movement of people between relatively distant geographical locations, and can involve travel by foot, bicycle, automobile, train, boat, bus, airplane, or other means, with or without luggage, and can be one way or round trip.
 *          [search] => Array
 *                  (
 *                       [pm-ot] => 607
 *                       [pm-view] => Teaser1
 *                       [pm-vi] => 10
 *                       [pm-l] => 0,4
 *                       [pm-o] => price-desc
 *                       [...] => @link ../../docs/readme-querystring-api.md for all parameters
 *                  )
 *      )
 * </code>
 * @var array $args
 */

/**
 * Get the database and config instance from the pressmind sdk
 */
$db = \Pressmind\Registry::getInstance()->get('db');
$config = \Pressmind\Registry::getInstance()->get('config');


/**
 * if you plan to set different fieldname for each objec type as the media object name,
 * you can specifiy a map like this:
 *
 * $calendar_titles = [
 *   607 => 'headline_default',
 *   608 => 'title_default',
 *   {ID_OBJECT_TYPE} => {FIELDNAME} (see database table objectdata_{ID_OBJECT_TYPE})
 * ];
 */
$calendar_titles = [];

// if we want to display object type specific titles, we habe to build a join for each object type table
$joins = [];
$field_titles = [];
foreach ($config['data']['primary_media_type_ids'] as $id_object_type) {
    if(empty($calendar_titles[$id_object_type])){
        continue;
    }
    $field_titles[] = 'mo'.$id_object_type.'.'.$calendar_titles[$id_object_type];
    $joins[] = 'left join objectdata_' . $id_object_type . ' mo' . $id_object_type . ' on (mo.id = mo' . $id_object_type . '.id_media_object)';

}

$title = 'mo.name';
if(!empty($field_titles)){
    $title = 'concat_ws("", '.implode(',', $field_titles).') as name';
}

$items = $db->fetchAll('select distinct  mo.id, ps.date_departure,
                            id_object_type, '.$title.'
                        from pmt2core_cheapest_price_speed ps
                            left join pmt2core_media_objects mo on (mo.id = ps.id_media_object)
                            ' . implode('', $joins) . '
                        where date_departure > now() order by date_departure limit 500;');

if (count($items) == 0) {
    return;
}
?>
<section class="content-block">
    <div class="row">
        <?php if (!empty($args['headline']) || !empty($args['text'])) { ?>
            <div class="col-12">
                <?php if (!empty($args['headline'])) { ?>
                    <h2 class="mt-0">
                        <?php echo $args['headline']; ?>
                    </h2>
                <?php } ?>
                <?php if (!empty($args['text'])) { ?>
                    <p>
                        <?php echo $args['text']; ?>
                    </p>
                <?php } ?>
            </div>
        <?php } ?>

        <div class="col-12">
        <?php

        foreach ($items as $item) {

            $date = new DateTime($item->date_departure);
            echo '<p>'.$item->id. ' - '. $date->format('d.m.Y').' ' . strip_tags($item->name). '</p>';
            $moc = new \Pressmind\ORM\Object\MediaObject($item->id);
            echo $moc->render('Teaser1', TS_LANGUAGE_CODE);
        }

        ?>
        </div>
    </div>
</section>