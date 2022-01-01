<?php
/**
 * <code>
 * $args['attributes']
 * </code>
 * @var array $args
 */
?>
<?php
if (!empty($args['attributes'])) { ?>
    <p class="attribute-row">
        <span class="badge badge-secondary"><?php echo implode('</span> <span class="badge badge-secondary">', $args['attributes']); ?></span>
    </p>
<?php } ?>