<?php
/**
 * @var \Pressmind\ORM\Object\MediaObject\DataType\Picture[] $pictures
 */
$pictures = $args;

?>
<div class="detail-image-grid">
    <div class="row">
        <?php if(!empty($pictures[0])){?>
        <div class="col-12 col-md-9">
            <div class="detail-image-grid-holder">
                <div class="detail-image-grid-holder-inner">

                    <?php if(is_object($pictures[0])){?>
                    <img class="w-100 h-100"
                         src="<?php echo $pictures[0]->getUri('detail'); ?>"
                         data-toggle="tooltip"
                         data-placement="bottom" data-html="true"
                         alt="<?php echo $pictures[0]->alt; ?>"
                         title="<?php
                         $caption = [];
                         $caption[] = !empty($pictures[0]->caption) ? $pictures[0]->caption : '';
                         $caption[] = !empty($pictures[0]->copyright) ? '<small>' . $pictures[0]->copyright . '</small>' : '';
                         echo implode('<br>', array_filter($caption));
                         ?>"/>
                    <?php }elseif(is_string($pictures)){
                        // @TODO the placeholder image below is only for a better theme developer onboarding, remove in production.
                        // if the property "$moc->bilder_default" is not set in this object type, check if there is another named image property
                    ?>
                    <img src="/placeholder.svg?wh=250x170&text=<?php echo urlencode($pictures);?>" class="card-img-top">

                    <?php }?>


                </div>
            </div>
        </div>
        <?php } ?>
        <div class="col-12 col-md-3">
            <div class="row">
                <?php if(!empty($pictures[1])){ ?>
                <div class="col-6 col-md-12">
                    <div class="detail-image-grid-holder detail-image-grid-holder--small">
                        <div class="detail-image-grid-holder-inner">
                            <?php if(is_object($pictures[1])){?>
                            <img class="w-100 h-100"
                                 src="<?php echo $pictures[1]->getUri('detail_thumb'); ?>"
                                 data-toggle="tooltip"
                                 data-placement="bottom" data-html="true"
                                 alt="<?php echo $pictures[1]->alt; ?>"
                                 title="<?php
                                 $caption = [];
                                 $caption[] = !empty($pictures[1]->caption) ? $pictures[1]->caption : '';
                                 $caption[] = !empty($pictures[1]->copyright) ? '<small>' . $pictures[1]->copyright . '</small>' : '';
                                 echo implode('<br>', array_filter($caption));
                                 ?>"/>
                            <?php }elseif(is_string($pictures)){
                                // @TODO the placeholder image below is only for a better theme developer onboarding, remove in production.
                                // if the property "$moc->bilder_default" is not set in this object type, check if there is another named image property
                                ?>
                                <img src="/placeholder.svg?wh=250x170&text=<?php echo urlencode($pictures);?>" class="w-100 h-100">
                            <?php }?>

                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php if(!empty($pictures[2])){ ?>
                <div class="col-6 col-md-12">
                    <div class="detail-image-grid-holder detail-image-grid-holder--small detail-image-grid-holder--more">
                          <span class="more-images">
                              <?php
                              if (is_array($pictures) && count($pictures) - 3 > 0) {
                                  ?>
                                  <span class="count">
                                    +<?php echo count($pictures) - 3; ?>
                                  </span>
                                  <?php
                              }
                              ?>
                          </span>
                        <div class="detail-image-grid-holder-inner">

                            <?php if(is_object($pictures[1])){?>
                            <img class="w-100 h-100"
                                 src="<?php echo $pictures[2]->getUri('detail_thumb'); ?>"
                                 data-toggle="tooltip"
                                 data-placement="bottom" data-html="true"
                                 alt="<?php echo $pictures[2]->alt; ?>"
                                 title="<?php
                                 $caption = [];
                                 $caption[] = !empty($pictures[2]->caption) ? $pictures[2]->caption : '';
                                 $caption[] = !empty($pictures[2]->copyright) ? '<small>' . $pictures[2]->copyright . '</small>' : '';
                                 echo implode('<br>', array_filter($caption));
                                 ?>"/>
                            <?php }elseif(is_string($pictures)){
                                // @TODO the placeholder image below is only for a better theme developer onboarding, remove in production.
                                // if the property "$moc->bilder_default" is not set in this object type, check if there is another named image property
                                ?>
                                <img src="/placeholder.svg?wh=250x170&text=<?php echo urlencode($pictures);?>" class="w-100 h-100">
                            <?php }?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>