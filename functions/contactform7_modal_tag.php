<?php
/**
 * Add the custom field "modal" field
 * This generates a modal link for disclaimer, gdpr, agb, etc... NOT a input field, it's because the cf7 forms have it's own shortcode methods
 * and the wordpress shortcode are not supported here.
 *
 * Example usage:
 * <code>
 *   [modal privacy id_post:542 "Datenschutz"]
 *   [modal {A NAME} id_post:{POST ID} "{LINK NAME}"]
 * </code>
 */
add_action('wpcf7_init', function () {
    wpcf7_add_form_tag(array('modal'), function ($tag) {

        /**
         * @var WPCF7_FormTag $tag
         */

        $id_post = $tag->get_option('id_post', '', true);

        if (empty($id_post) || empty($tag->name)) {
            return 'error: shortcode [modal...] not valid, post-id or name is missing example [modal my-name id_post:123 "the link name"]';
        }

        $post = get_post($id_post);

        if(empty($post)){
            return 'error: post for id ('.$id_post.') for not found (cf7-shortcode [modal... ])';
        }

        $args = [
            'name' => '',
            'title' => $post->post_title,
            'id_post' => $id_post,
            'div_only' => true,
            'content' =>  apply_filters('the_content', $post->post_content)
        ];

        ob_start();
        require get_template_directory().'/template-parts/layout-blocks/modalscreen.php';
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    },
        array(
            'name-attr' => true,
            'selectable-values' => true,
            'multiple-controls-container' => true,
        ));
});



