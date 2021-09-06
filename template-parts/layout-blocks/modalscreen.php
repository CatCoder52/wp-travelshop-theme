<?php
/**
 * This modal can be called from two different ways:
 *
 * 1. From this generic WordPress Shortcode
 *      @example : [ts-modal id_post="124" name="Datenschutz"]
 *      @see /src/Shortcodes.php:modal()
 *
 * 2. From a cf7 form by this shortcode:
 *      @example [modal privacy post-id:542 "Datenschutz"]
 *      @see /functions/contactform7_modal_tag.php
 *
 * @var array $args{name:string,title:string,content:string,id_post:int,div_only:boolean};
 */

if(isset($args['div_only']) && $args['div_only'] === false){
    ?>
    <a href="<?php echo get_permalink($args['id_post']);?>" data-modal="true" data-modal-id="modal-id-post-<?php echo $args['id_post'];?>"><?php echo $args['name'];?></a>
    <?php
}
?>
<div class="modal-forms modal-wrapper" id="modal-id-post-<?php echo $args['id_post'];?>">
    <div class="modal-inner">
        <button type="button" class="modal-close"><span></span></button>
        <div class="modal-body-outer">
            <div class="modal-body">
                <div class="modal-title container"><?php echo $args['title'];?></div>
                <?php echo $args['content']; ?>
            </div>
        </div>
    </div>
</div>

