<section class="content-block content-block-history">
    <div class="row">
       <div class="col-12">
           <?php
           if ( $args['items'] && count($args['items']) > 0 ) {
               echo "<div class='history-group'>";
               foreach ( $args['items'] as $item ) {
                   echo "<article class='history-item'>";

                        // history item dot
                        $dotClass = 'history-item--dot';
                        $dotStyle = '';

                        if ( !empty($item['dot_color']) ) {
                            $dotStyle = 'background-color: ' . $item['dot_color'] . ';';
                        }
                        if ( $item['dot_type'] == 'svg' ) {
                            $dotClass = 'history-item--dot is-svg';
                        }

                        if ( !empty($item['image_id'])){
                            $item['image'] = wp_get_attachment_image_url( $item['image_id'], 'medium_original');
                        };

                       // history item row
                       echo "<div class='row'>";

                           // history item date
                           echo "<div class='col-12 col-md-6'>";
                               if ( !empty($item['date']) ) {
                                   echo "<div class='history-item--date'>";
                                       echo $item['date'];
                                   echo "</div>";
                               }
                           echo "</div>";

                           // history item content
                           echo "<div class='col-12 col-md-6'>";
                               echo "<div class='history-item--content'>";

                                   echo "<div class='" . $dotClass . "' style='" . $dotStyle . "'>";
                                       if ( $item['dot_type'] == 'svg' && !empty($item['dot_svg']) ) {
                                           echo $item['dot_svg'];
                                       }
                                   echo "</div>";

                                    if ( !empty($item['headline']) ) {
                                        echo "<h1>" . $item['headline'] . "</h1>";
                                    }

                                    if ( !empty($item['text']) ) {
                                        echo "<div class='history-item--text'>";
                                            echo $item['text'];
                                        echo "</div>";
                                    }

                                    if ( !empty($item['image']) ) {
                                        $alt_text = $item['headline'] ? $item['headline'] : '';
                                        $alt_text = $item['image_alt_text'] ? $item['image_alt_text'] : $alt_text;

                                        $image_class = 'history-item--image';
                                        $caption_text = $item['image_caption_text'] ? $item['image_caption_text'] : '';

                                        if ( $item['image_caption_text'] && !empty($item['image_caption_text']) ) {
                                            $image_class .= ' has-caption';
                                        }

                                        echo "<figure>";
                                            echo "<div class='".$image_class."'>";
                                                echo "<img alt='".$alt_text."' src='".$item['image']."' />";
                                            echo "</div>";

                                            if ( !empty($caption_text) ) {
                                                echo "<figcaption>";
                                                    echo "<i class='small'>" . $caption_text . "</i>";
                                                echo "</figcaption>";
                                            }
                                        echo "</figure>";
                                    }


                               echo "</div>";
                           echo "</div>";

                       echo "</div>";

                   echo "</article>";
               }
               echo "</div>";
           }
           ?>
       </div>
    </div>
</section>