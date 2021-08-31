 <?php

 /**
  * <code>
  *  $args = (
  *          [headline] => Reise-Empfehlungen
  *          [text] => Travel is the movement of people between relatively distant geographical locations, and can involve travel by foot, bicycle, automobile, train, boat, bus, airplane, or other means, with or without luggage, and can be one way or round trip.
  *      )
  * </code>
  * @var array $args
  */

 use Pressmind\Search\CheapestPrice;
 use Pressmind\HelperFunctions;
 use Pressmind\Travelshop\PriceHandler;


 /**
  * Get the database and config instance from the pressmind sdk
  */
 $db = \Pressmind\Registry::getInstance()->get('db');
 $config = \Pressmind\Registry::getInstance()->get('config');


 /**
  * if you plan to set different fieldnames for each object type as the media object name,
  * you can specify a map like this:
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
     if (empty($calendar_titles[$id_object_type])) {
         continue;
     }
     $field_titles[] = 'mo' . $id_object_type . '.' . $calendar_titles[$id_object_type];
     $joins[] = 'left join objectdata_' . $id_object_type . ' mo' . $id_object_type . ' on (mo.id = mo' . $id_object_type . '.id_media_object)';

 }

 $title = 'mo.name';
 if (!empty($field_titles)) {
     $title = 'concat_ws("", ' . implode(',', $field_titles) . ') as name';
 }

 $items = $db->fetchAll('select distinct  mo.id, ps.date_departure,
                            id_object_type, ' . $title . '
                        from pmt2core_cheapest_price_speed ps
                            left join pmt2core_media_objects mo on (mo.id = ps.id_media_object)
                            ' . implode('', $joins) . '
                        where date_departure > now() order by date_departure limit 500;');

 // abort if nothing to display
 if (count($items) == 0) {
     return;
 }

 // -- Group Items by Month/Year
 $itemsGroupedByMonth = [];
 foreach ($items as $item) {
     $item->date_departure = new DateTime($item->date_departure);
     $itemsGroupedByMonth[$item->date_departure->format('m.Y')][] = $item;
 }

 ?>

 <section class="content-block content-block-month-teaser">
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
             <div class="row month-teaser-group">
                 <?php
                 // -- use Grouped Array to render Items
                 $month_count = 1;
                 foreach ($itemsGroupedByMonth as $items) {

                     echo "<div class='col-12 col-sm-6 col-lg-4'>";
                         echo "<div class='teaser month-teaser'>";

                            $countItems = count($items);
                            $countItems = $countItems - 1;
                            $randItem = rand( 0, $countItems );


                            $month_title = HelperFunctions::monthNumberToLocalMonthName($items[$randItem]->date_departure->format('n'));
                            $month_title .= $items[$randItem]->date_departure->format('Y') != date('Y') ? ' ' . $items[$randItem]->date_departure->format('Y') : '';

                            // -- get data from first item
                             $CheapestPriceFilter = new CheapestPrice();
                             $CheapestPriceFilter->date_from = $CheapestPriceFilter->date_to = $items[$randItem]->date_departure;
                             $CheapestPriceFilter->occupancies = [2];

                             $mo = new \Pressmind\ORM\Object\MediaObject($items[$randItem]->id);
                             $cheapest_price = $mo->getCheapestPrice($CheapestPriceFilter);
                             $moc = $mo->getDataForLanguage(TS_LANGUAGE_CODE);

                            echo "<a href='/' title='" . $month_title . "'>";

                                // month image
                                echo "<div class='month-teaser-image'><div>";
                                    ?>
                                     <?php
                                     if (is_array($moc->bilder_default)) { ?>
                                         <img src="<?php echo $moc->bilder_default[0]->getUri('teaser'); ?>"
                                              title="<?php echo $moc->bilder_default[0]->copyright; ?>"
                                              alt="<?php echo strip_tags($mo->name); ?>"
                                              class="card-img-top"
                                              loading="lazy">
                                     <?php } elseif (is_string($moc->bilder_default)) {
                                         // @TODO the placeholder image below is only for a better theme developer onboarding, remove in production.
                                         // if the property "$moc->bilder_default" is not set in this object type, check if there is another named image property
                                         ?>
                                         <img src="<?php echo SITE_URL; ?>/wp-content/themes/travelshop/assets/img/placeholder.svg.php?wh=250x170&text=<?php echo urlencode($moc->bilder_default); ?>"
                                              class="card-img-top">
                                     <?php } ?>
                                     <?php
                                echo "</div></div>";

                                // month title
                                echo "<div class='month-teaser-title'>";
                                    echo $month_title;
                                    ?>
                                     <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 407.437 407.437" style="enable-background:new 0 0 407.437 407.437;" xml:space="preserve"> <polygon points="386.258,91.567 203.718,273.512 21.179,91.567 0,112.815 203.718,315.87 407.437,112.815 "/></svg>
                                     <?php
                                echo "</div>";

                            echo "</a>";

                         echo "</div>";
                     echo "</div>";

                 }
                 ?>
             </div>
         </div>

     </div>

 </section>
