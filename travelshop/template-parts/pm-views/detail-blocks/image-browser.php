<?php
/**
 * @var \Pressmind\ORM\Object\MediaObject\DataType\Picture[] $pictures
 */
$pictures = $args;

?>
<div class="detail-image-grid">
    <div class="row">
        <div class="col-12 col-md-9">
            <div class="detail-image-grid-holder">
                <div class="detail-image-grid-holder-inner">
                    <img class="w-100 h-100"
                         src="<?php echo $pictures[0]->getUri('detail'); ?>"
                         data-toggle="tooltip"
                         data-placement="bottom" data-html="true"
                         alt="<?php echo $pictures[0]->alt; ?>"
                         title="<?php echo $pictures[0]->caption; ?><br><small><?php echo $pictures[0]->copyright; ?></small>"/>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="row">
                <div class="col-6 col-md-12">
                    <div class="detail-image-grid-holder detail-image-grid-holder--small">
                        <div class="detail-image-grid-holder-inner">
                            <img class="w-100 h-100"
                                 src="<?php echo $pictures[1]->getUri('detail_thumb'); ?>"
                                 data-toggle="tooltip"
                                 data-placement="bottom" data-html="true"
                                 alt="<?php echo $pictures[1]->alt; ?>"
                                 title="<?php echo $pictures[1]->caption; ?><br><small><?php echo $pictures[1]->copyright; ?></small>"/>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-12">
                    <div class="detail-image-grid-holder detail-image-grid-holder--small detail-image-grid-holder--more">
                          <span class="more-images">
                              <?php
                              if (count($pictures) - 3 > 0) {
                                  ?>
                                  <span class="count">
                                    +<?php echo count($pictures) - 3; ?>
                                  </span>
                                  <?php
                              }
                              ?>
                          </span>
                        <div class="detail-image-grid-holder-inner">
                            <img class="w-100 h-100"
                                 src="<?php echo $pictures[2]->getUri('detail_thumb'); ?>"
                                 data-toggle="tooltip"
                                 data-placement="bottom" data-html="true"
                                 alt="<?php echo $pictures[2]->alt; ?>"
                                 title="<?php echo $pictures[2]->caption; ?><br><small><?php echo $pictures[2]->copyright; ?></small>"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>