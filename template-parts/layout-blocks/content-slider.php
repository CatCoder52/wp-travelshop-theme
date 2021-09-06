<?php
/**
 * <code>
 *  $args = [
 *      'items' => [
 *          [
 *             'type' => 'content', // enum(content, product)
 *             'title' => 'Weihnachtsmarkt auf der Fraueninsel mit Gut Aiderbichl',
 *             'text' => 'Ein romantisches Wintermärchen, das jedes Jahr Besucher von Nah und Fern aufs Neue begeistert, ist der Christkindlmarkt auf der Frauninsel. Festliche Beleuchtung, feinstes kunstwerk ...',
 *             'image' => get_stylesheet_directory_uri().'/assets/img/slide-1.jpg',
 *             'image_alt_tag' => '',
 *             'btn_link' => '/blog/',
 *             'btn_link_target' => '', enum(_blank, _self)
 *             'btn_label' => 'Weiterlesen'
 *          ],
 *          [
 *              'type' => 'product',
 *              'pm-id' => '869696'
 *              'image_type' => '', // enum(from_product, custom)
 *              'image' => get_stylesheet_directory_uri().'/assets/img/slide-1.jpg',
 *              'image_alt_tag' => '',
 *              'image_number' => 0,
 *          ]
 *      ]
 *  ];
 * </code>
 * @var array $args
 */

if (empty($args)) {
    return;
}
?>

<section class="content-block content-block-content-slider">
    <?php
    if (count($args['items']) > 1) {
        ?>
        <div class="content-slider--nav">
            <button class="prev-button">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     viewBox="0 0 407.437 407.437" style="enable-background:new 0 0 407.437 407.437;"
                     xml:space="preserve">
                     <polygon points="386.258,91.567 203.718,273.512 21.179,91.567 0,112.815 203.718,315.87 407.437,112.815 "></polygon>
                </svg>
            </button>
            <button class="next-button">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     viewBox="0 0 407.437 407.437" style="enable-background:new 0 0 407.437 407.437;"
                     xml:space="preserve">
                      <polygon points="386.258,91.567 203.718,273.512 21.179,91.567 0,112.815 203.718,315.87 407.437,112.815 "></polygon>
                </svg>
            </button>
        </div>
        <?php
    }
    ?>
    <div class="content-slider--inner">
        <?php
        foreach ($args['items'] as $item) {

            $image_url = '/placeholder.svg?wh=800x800&text=image not set';
            $image_alt_tag = '';
            if ($item['type'] == 'product') {
                if(empty((int)$item['pm-id'])){
                    continue;
                }

                $mo = new \Pressmind\ORM\Object\MediaObject((int)$item['pm-id']);
                $moc = $mo->getDataForLanguage(TS_LANGUAGE_CODE);
                if($item['image_type'] == 'from_product'){
                    if (is_array($moc->bilder_default)) {
                        if(!isset($moc->bilder_default[$item['image_number']])){
                            $item['image_number'] = 0;
                        }
                        $image_url = $moc->bilder_default[$item['image_number']]->getUri('detail');
                        $image_alt_tag = $moc->bilder_default[$item['image_number']]->copyright();
                    } elseif (is_string($moc->bilder_default)) {
                        $image_url = SITE_URL . "/wp-content/themes/travelshop/assets/img/placeholder.svg.php?wh=250x170&text=" . urlencode($moc->bilder_default);
                    }
                }
            }

            if (!empty($item['image']) && ($item['type'] == 'content' || $item['image_type'] == 'custom')) {
                $image_url = $item['image'];
                $image_alt_tag = $item['image_alt_tag'];
            }

            ?>
            <article class="content-slider--item content-slider--item__<?php echo $item['type']; ?>">
                <div class="content-slider--image">
                    <div style="background-image: url('<?php echo $image_url; ?>');"></div>
                </div>
                <div class="content-slider--content">
                    <div class="container">
                        <?php
                        if ($item['type'] == 'content') {
                            ?>
                            <div class="card">
                                <div class="card-body">
                                    <h1><?php echo $item['title']; ?></h1>
                                    <p><?php echo $item['text']; ?></p>
                                    <a class="btn btn-primary" href="<?php echo $item['btn_link']; ?>" target="<?php echo !empty($item['btn_link_target']) ? $item['btn_link_target'] : '_self';?>"><?php
                                        if (!empty($item['btn_label'])) {
                                            echo $item['btn_label'];
                                        } else {
                                            echo "Mehr erfahren";
                                        }
                                        ?></a>
                                </div>
                            </div>
                            <?php
                        } elseif ($item['type'] == 'product') {
                            echo $mo->render('Teaser6', TS_LANGUAGE_CODE);
                        }
                        ?>
                    </div>
                </div>
            </article>
            <?php
        }
        ?>
    </div>
</section>
