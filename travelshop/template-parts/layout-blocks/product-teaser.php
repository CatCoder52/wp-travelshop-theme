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

       // Example 1: Using the the shortcode ts-list for displaying the product teasers
       //echo do_shortcode( '[ts-list view="Teaser1" pm-ot="607" pm-l="1,4" pm-o="RAND"]');
       // Note: the View-Template "Teaser1" can be found in travelshop/template-parts/pm-views/{OBJECT_TYPE_NAME}_{VIEWNAME}.php


       // Example 2: Using the pressmind® web-core SDK
       $conditions = array();
       $conditions[] = Pressmind\Search\Condition\ObjectType::create(TS_LANGUAGE_CODE);
       $search = new Pressmind\Search($conditions, ['start' => 0, 'length' => 4], ['' => 'RAND()']);
       $products = $search->getResults();
       foreach ($products as $product) {
           echo  $product->render('Teaser1', TS_LANGUAGE_CODE);
       }



       ?>
    </div>
</section>