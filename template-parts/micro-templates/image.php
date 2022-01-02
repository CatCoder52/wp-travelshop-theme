<?php
/**
 * <code>
 * $args['image']
 * $args['class']
 * $args['width']
 * $args['height']
 * </code>
 * @var array $args
 */

if (!empty($args['image']['url'])) { ?>
    <img src="<?php echo $args['image']['url']; ?>"
         title="<?php echo $args['image']['copyright']; ?>"
         alt="<?php echo $args['headline']; ?>"
         width="<?php echo $args['image']['size']['width']; ?>"
         height="<?php echo $args['image']['size']['height']; ?>"
         class="<?php echo $args['class'];?>"
         loading="lazy">
<?php } else { ?>
    <img src="/placeholder.svg?wh=<?php echo $args['width'];?>x<?php echo $args['height'];?>" class="<?php echo $args['class'];?>">
<?php } ?>