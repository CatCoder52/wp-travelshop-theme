<?php
/**
 * <code>
 *  $args['headline']
 *  $args['text']
 *  $args['view']
 *  $args['teaser_count_desktop'] = 3
 *  $args['teasers'][][ // list of teasers
 *          [headline] => We make it!
 *          [image] => Image path
 *          [link] =>
 *          [link_target] => _self
 *          [link_nofollow] => no
 *          [search]=> Array
 *                  (
 *                       [pm-ot] => 607
 *                       [pm-view] => Teaser1
 *                       [pm-vi] => 10
 *                       [pm-l] => 0,4
 *                       [pm-o] => price-desc
 *                       [...] => @link ../../docs/readme-querystring-api.md for all parameters
 *                  )

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

            // if is empty or is not divide trough 12, set default
            if(empty($args['teaser_count_desktop']) || 12 % $args['teaser_count_desktop'] != 0){
                $args['teaser_count_desktop'] = 3;
            }

            foreach($args['teasers'] as $teaser){

                $image = !empty($teaser['image']) ? $teaser['image'] : get_stylesheet_directory_uri() . '/assets/img/slide-1-mobile.jpg';
                ?>
                <div class="col-12 col-sm-6 <?php echo 'col-lg-'.(12/$args['teaser_count_desktop']); ?>">
                    <article class="teaser category-teaser">

                        <div class="teaser-category-image">
                            <a href="<?php echo $teaser['link'];?>" target="<?php echo !empty($teaser['link_target']) ? $teaser['link_target'] : '_self';?>">
                                <div class="teaser-image" style="background-image: url('<?php echo $image; ?>');">
                                </div>
                                <div class="teaser-body">
                                    <?php if(!empty($teaser['headline'])){ ?>
                                        <h1 class="teaser-title h5">
                                            <?php echo $teaser['headline'];?>
                                        </h1>
                                    <?php } ?>
                                </div>
                            </a>
                        </div>

                    <?php
                        $search = BuildSearch::fromRequest($teaser['search'] ?? [], 'pm', true, 4);
                        $products = $search->getResults();
                        if(count($products) > 0){
                    ?>
                        <div class="teaser-body">
                            <div class="row teaser-products">
                                <?php
                                try{
                                    foreach ($products as $product) {
                                        echo  $product->render($args['view'] ?? 'Teaser4', TS_LANGUAGE_CODE);
                                    }
                                }catch (Exception $e){
                                    echo $e->getMessage();
                                }

                                ?>
                            </div>
                        </div>
                    <?php } ?>
                    </article>
                </div>
                <?php
            }
        }
        ?>
    </div>
</section>