<section class="content-block content-block-travel-cols">
    <div class="row">

        <div class="col-12">
            <h2 class="mt-0">
                Reise-Empfehlungen
            </h2>
            <p>
                Diese Teaser werden durch das pressmind® web-core sdk bereitgestellt.
                Man kann diese auf jeder beliebigen Seite mit einem Shortcode ausgeben.
                <br>
                <span class="small">Template: wp-content/themes/travelshop/template-parts/layout-blocks/product-teaser.php</span>
            </p>
        </div>

       <?php

       //@todo

       // Examples "How to display for random products as teaser"
       // Note: the View-Template "Teaser1" can be found in travelshop/template-parts/pm-views/{OBJECT_TYPE_NAME}_{VIEWNAME}.php

       // Example 1: Using the the shortcode ts-list for displaying the product teasers
       echo do_shortcode( '[ts-list view="Teaser1" pm-ot="607" pm-l="1,4" pm-o="RAND"]');


       // Example 2: Using the pressmind® web-core SDK
       /*
       $conditions = array();
       $conditions[] = Pressmind\Search\Condition\ObjectType::create(607);
       //$conditions[] = Pressmind\Search\Condition\PriceRange::create(1, 9999);
       //$conditions[] = Pressmind\Search\Condition\PriceRange::create(new DateTime($atts['date_range_from']), new DateTime($atts['date_range_to']));
       $search = new Pressmind\Search($conditions, ['start' => 0, 'length' => 4], ['' => 'RAND()']);
       $products = $search->getResults();
       foreach ($products as $product) {
           echo  $product->render('Teaser1', 'de');
       }
       */

       ?>
    </div>
</section>