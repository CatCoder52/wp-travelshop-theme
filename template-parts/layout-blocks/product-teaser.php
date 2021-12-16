<?php
use Pressmind\Travelshop\Search;
use Pressmind\Travelshop\Template;

/**
 * <code>
 *  $args = (
 *          [headline] => [TOTAL_RESULT] Reise-Empfehlungen
 *          [text] => [TOTAL_RESULT] products found. Travel is the movement of people between relatively distant geographical locations, and can involve travel by foot, bicycle, automobile, train, boat, bus, airplane, or other means, with or without luggage, and can be one way or round trip.
 *          [view] => Teaser1
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


// @todo: replace this, pm-li had no effect!
$page_size = 4;

if ( isset ( $args['search']['pm-li'] ) && !empty($args['search']['pm-li']) ) {
    $page_size = explode(',', $args['search']['pm-li']);
    $page_size = (int)$page_size[1];
}


$result = Search::getResult(isset($args['search']) ? $args['search'] : [], 2, $page_size, true, false);
if(count($result['items']) == 0){
    return;
}
$countItems = $result['items'];
$moreResultsLink = '/mehr-reisen-link/';
?>
<section class="content-block content-block-travel-cols">
    <div class="row">
        <?php if(!empty($args['headline']) || !empty($args['intro'])){ ?>

            <div class="col-12 <?php if ( isset($args['link_top']) && $args['link_top'] === true ) { ?>col-md<?php } ?>">
                <?php if(!empty($args['headline'])){ ?>
                <h2 class="mt-0">
                    <?php echo str_replace('[TOTAL_RESULT]', $result['total_result'], $args['headline']);?>
                </h2>
                <?php } ?>
                <?php if(!empty($args['text'])){ ?>
                <p>
                    <?php echo str_replace('[TOTAL_RESULT]', $result['total_result'], $args['text']);?>
                </p>
                <?php } ?>
            </div>
        <?php if ( isset($args['link_top']) && $args['link_top'] === true ) { ?>
            <div class="col-12 col-md-auto pb-4">
                <a href="<?php echo $moreResultsLink; ?>" title="<?php echo str_replace('[TOTAL_RESULT]', $result['total_result'], $args['link_top_text']);?>" class="btn btn-link btn-further">
                    <?php echo str_replace('[TOTAL_RESULT]', $result['total_result'], $args['link_top_text']);?>
                </a>
            </div>
        </div>
        <div class="row">
        <?php } ?>
        <?php } ?>
        <?php

       // Example 1: Using the the shortcode ts-list for displaying the product teasers
       //echo do_shortcode( '[ts-list view="Teaser1" pm-ot="607" pm-l="1,4" pm-o="RAND"]');
       // Note: the View-Template "Teaser1" can be found in travelshop/template-parts/pm-views/{OBJECT_TYPE_NAME}_{VIEWNAME}.php


       // Example 2: Using the pressmind® web-core SDK (MySQL)
       //$conditions = array();
       //$conditions[] = Pressmind\Search\Condition\ObjectType::create(TS_TOUR_PRODUCTS);
       //$search = new Pressmind\Search($conditions, ['start' => 0, 'length' => 4], ['' => 'RAND()']);
       //$products = $search->getResults();
       //foreach ($products as $product) {
       //    echo  $product->render('Teaser1', TS_LANGUAGE_CODE);
       //}

       // Example 3: Use a $args['search] list (or $_GET)
       // $search = BuildSearch::fromRequest(isset($args['search']) ? $args['search'] : [], 'pm', true, 4);
       // $products = $search->getResults();

        $view = 'Teaser1';
        if(!empty($args['view']) && preg_match('/^[0-9A-Za-z\_]+$/', $args['view']) !== false){
            $view = $args['view'];
        }

        foreach ($result['items'] as $item) {
            echo Template::render(get_stylesheet_directory().'/template-parts/pm-views/'.$view.'.php', $item);
        }


        if (isset($args['link_teaser']) && $args['link_teaser'] === true) {
            ?>
            <div class="col-12 col-md-6 col-lg-3 card-travel-wrapper-link text-center pb-3">
                <a class="btn-further btn-teaser-link d-none d-md-flex" href="btn-further-teaser" href="<?php echo $moreResultsLink; ?>" title="<?php echo str_replace('[TOTAL_RESULT]', $result['total_result'], $args['link_teaser_text']);?>">
                    <?php echo str_replace('[TOTAL_RESULT]', $result['total_result'], $args['link_teaser_text']);?>
                </a>
                <?php if ( isset($args['link_bottom']) && $args['link_bottom'] === false ) { ?>
                <a class="btn btn-primary btn-further d-inline d-md-none" href="btn-further-teaser" href="<?php echo $moreResultsLink; ?>" title="<?php echo str_replace('[TOTAL_RESULT]', $result['total_result'], $args['link_teaser_text']);?>">
                    <?php echo str_replace('[TOTAL_RESULT]', $result['total_result'], $args['link_teaser_text']);?>
                </a>
                <?php } ?>
            </div>
            <?php
        }
        ?>
    </div>

    <?php if ( isset($args['link_bottom']) && $args['link_bottom'] === true ) { ?>
    <div class="row">
        <div class="col-12 text-center pb-4">
            <a href="<?php echo $moreResultsLink; ?>" title="<?php echo str_replace('[TOTAL_RESULT]', $result['total_result'], $args['link_bottom_text']);?>" class="btn btn-primary btn-lg btn-further">
                <?php echo str_replace('[TOTAL_RESULT]', $result['total_result'], $args['link_bottom_text']);?>
            </a>
        </div>
    </div>
    <?php } ?>
</section>