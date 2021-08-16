<?php
/**
 * <code>
 *  $args['headline']
 *  $args['text']
 *  $args['teasers'][][ // list of teasers
            [headline] => We make it!
            [image] => Image path
            [link] =>
            [link_target] => _self
            [link_nofollow] => no
            [search] => search parameters for list products

 *                  ]
 *

 * </code>
 * @var array $args
 */

?>
<section class="content-block content-block-teaser-group">
    <div class="row">
        <?php if(!empty($args['headline']) || !empty($args['text'])){ ?>
            <div class="col-12">
                <?php if(!empty($args['headline'])){ ?>
                    <h2 class="mt-0">
                        <?php echo $args['headline'];?>
                    </h2>
                <?php } ?>
                <?php if(!empty($args['text'])){ ?>
                    <p><?php echo $args['text'];?></p>
                <?php } ?>
            </div>
        <?php } ?>

        <?php
        if(!empty($args['teasers'])){
            foreach($args['teasers'] as $teaser){
                $teaser = (array)$teaser;
                ?>
                <div class="col-12 col-sm-6 col-lg-3">
                    <article class="teaser category-teaser">

                        <?php
                            load_template(get_template_directory().'/template-parts/wp-views/category-image-teaser-view.php', false, $teaser);
                        ?>

                        <div class="teaser-body">
                            <div class="row teaser-products">
                                <?php
                                $search = BuildSearch::fromRequest(isset($teaser['search']) ? $teaser['search'] : [], 'pm', true, 4);
                                $products = $search->getResults();
                                // if no items where found, we avoid output like headline or intro text...
                                if(count($products) == 0){
                                    return;
                                }
                                $view = 'Teaser4';
                                if(!empty($args['view']) && preg_match('/^[0-9A-Za-z\_]+$/', $args['view']) !== false){
                                    $view = $args['view'];
                                }
                                foreach ($products as $product) {
                                    echo  $product->render($view, TS_LANGUAGE_CODE);
                                }
                                ?>
                            </div>
                        </div>
                    </article>
                </div>
                <?php
            }
        }
        ?>
    </div>
</section>