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

global $db;

$items = $db->fetchAll('select distinct  id_media_object, date_departure, mo.name from pmt2core_cheapest_price_speed ps
left join pmt2core_media_objects mo on (mo.id = ps.id_media_object)
where date_departure > now()
order by date_departure;');

if(count($items) == 0){
    return;
}
?>
<section class="content-block">
    <div class="row">
        <?php if(!empty($args['headline']) || !empty($args['text'])){ ?>
        <div class="col-12">
            <?php if(!empty($args['headline'])){ ?>
            <h2 class="mt-0">
                <?php echo $args['headline'];?>
            </h2>
            <?php } ?>
            <?php if(!empty($args['text'])){ ?>
            <p>
                <?php echo $args['text'];?>
            </p>
            <?php } ?>
        </div>
        <?php } ?>

        <?php

        // Calendar here

        /*foreach ($items as $item) {
            echo $item->id_media_object.'<br>';
            //echo  $product->render($view, TS_LANGUAGE_CODE);
        }*/

       ?>
    </div>
</section>