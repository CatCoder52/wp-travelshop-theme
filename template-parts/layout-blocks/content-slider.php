<?php


use Pressmind\Search\CheapestPrice;
use Pressmind\HelperFunctions;
use Pressmind\Travelshop\PriceHandler;

/**
 * Get the database and config instance from the pressmind sdk
 */
$db = \Pressmind\Registry::getInstance()->get('db');
$config = \Pressmind\Registry::getInstance()->get('config');
?>

<section class="content-block content-block-content-slider">

    <?php
        if ( count($args['items']) > 1 ) {
            ?>
            <div class="content-slider--nav">
                <button class="prev-button">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 407.437 407.437" style="enable-background:new 0 0 407.437 407.437;" xml:space="preserve">
                                        <polygon points="386.258,91.567 203.718,273.512 21.179,91.567 0,112.815 203.718,315.87 407.437,112.815 "></polygon>
                                    </svg>
                </button>
                <button class="next-button">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 407.437 407.437" style="enable-background:new 0 0 407.437 407.437;" xml:space="preserve">
                                        <polygon points="386.258,91.567 203.718,273.512 21.179,91.567 0,112.815 203.718,315.87 407.437,112.815 "></polygon>
                                    </svg>
                </button>
            </div>
            <?php
        }
    ?>

    <div class="content-slider--inner">

        <?php
        foreach ( $args['items'] as $item ) {

            echo "<article class='content-slider--item content-slider--item__".$item['type']."'>";

                if( $item['type'] == 'product' ) {
                    $mo = new \Pressmind\ORM\Object\MediaObject($item['id']);
                }

                echo "<div class='content-slider--image'>";
                    if ( $item['type'] == 'content' ) {
                        echo "<div style='background-image: url(".$item['content']['image'].")'></div>";
                    } elseif ( $item['type'] == 'product' ) {
                        $moc = $mo->getDataForLanguage(TS_LANGUAGE_CODE);

                        if (is_array($moc->bilder_default)) {
                            $image_url = $moc->bilder_default[0]->getUri('slider');
                        } elseif (is_string($moc->bilder_default)) {
                            $image_url = SITE_URL . "/wp-content/themes/travelshop/assets/img/placeholder.svg.php?wh=250x170&text=" . urlencode($moc->bilder_default);
                        }
                        echo "<div style='background-image: url(".$image_url.")'></div>";
                    }
                echo "</div>";


                echo "<div class='content-slider--content'><div class='container'>";
                    if( $item['type'] == 'content' ) {

                        echo "<div class='card'><div class='card-body'>";

                        echo "<h1>" . $item['content']['title'] . "</h1>";

                        if ( $item['content']['text'] ) {
                            echo "<p>" . $item['content']['text'] . "</p>";
                        }

                        if ( $item['content']['link'] ) {
                            echo "<a class='btn btn-primary' href='".$item['content']['link']."'>";

                            if ( $item['content']['linktext'] ) {
                                echo $item['content']['linktext'];
                            } else {
                                echo "Mehr erfahren";
                            }

                            echo "</a>";
                        }

                        echo "</div></div>";

                    } elseif ( $item['type'] == 'product' ) {

                        echo $mo->render('Teaser6', TS_LANGUAGE_CODE);

                    }
                echo "</div></div>";

            echo "</article>";

        }
        ?>

    </div>

</section>
