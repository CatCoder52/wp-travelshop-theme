<?php
/**
 * Add the custom field "imgbtn" field
 * Example usage:
 * <code>
 * [imgbtn* catalogs
 * "Summer 2021::summer.jpg::https://pressmind.de/"
 * "Winter 2021::winter.jpg"
 * "{NAME AND VALUE}::{IMAGE PATH}::{LINK ON IMAGE}"
 * ]
 * </code>
 */

add_action('wpcf7_init', function () {

    wpcf7_add_form_tag(array('imgbtn', 'imgbtn*'), function ($tag) {

        /**
         * @var WPCF7_FormTag $tag
         */

        if (empty($tag->name)) {
            return '';
        }

        /**
         * checkbox or radio imgbtn
         * checkbox = must select one, can select many
         * radio = must select one, can select one
         */
        $field_type = 'checkbox';
        if (!empty($tag->get_option('type')[0]) && in_array($tag->get_option('type')[0], ['radio', 'checkbox'])) {
            $field_type = $tag->get_option('type')[0];
        }

        $class = wpcf7_form_controls_class($tag->type);

        $validation_error = wpcf7_get_validation_error($tag->name);
        if ($validation_error) {
            $class .= ' wpcf7-not-valid';
        }

        $exclusive = $tag->has_option('exclusive');
        $multiple = false;

        if ($field_type == 'checkbox') {
            $multiple = !$exclusive;
        } else { // radio
            $exclusive = false;
        }

        if ($exclusive) {
            $class .= ' wpcf7-exclusive-imgbtn';
        }

        $atts = array();
        $atts['class'] = $tag->get_class_option($class);
        $atts['class'] .= ' imgbtns';
        $atts['id'] = $tag->get_id_option();
        if ($tag->is_required()) {
            $atts['aria-required'] = 'true';
        }

        if ($validation_error) {
            $atts['aria-describedby'] = wpcf7_get_validation_error_reference($tag->name);
        }

        $tabindex = $tag->get_option('tabindex', 'signed_int', true);

        if (false !== $tabindex) {
            $tabindex = (int)$tabindex;
        }

        $html = '<div class="imgbtn-wrapper">';
        $count = 0;

        if ($data = (array)$tag->get_data_option()) {
            $tag->values = array_merge($tag->values, array_values($data));
            $tag->labels = array_merge($tag->labels, array_values($data));
        }

        $default_choice = $tag->get_default_option(null, array(
            'multiple' => $multiple,
        ));

        $hangover = wpcf7_get_hangover($tag->name, $multiple ? array() : '');

        foreach ($tag->values as $key => $value) {
            if ($hangover) {
                $checked = in_array($value, (array)$hangover, true);
            } else {
                $checked = in_array($value, (array)$default_choice, true);
            }

            if (isset($tag->labels[$key])) {
                $label = $tag->labels[$key];
            } else {
                $label = $value;
            }

            /**
             * each label have this format:
             * "Summer 2021::summer.jpg::https://link.de/"
             * so we have to split it here
             */

            @list($label, $image, $link) = explode('::', $label);

            $item_atts = wpcf7_format_atts([
                'type' => $field_type,
                'name' => $tag->name . ($multiple ? '[]' : ''),
                'value' => $label,
                'checked' => $checked ? 'checked' : '',
                'tabindex' => false !== $tabindex ? $tabindex : ''
            ]);


            $item = '<label><div class="imgbtn-item--image">';
            if (!empty($link)) {
                $linkIcon = '<svg xmlns="http://www.w3.org/2000/svg" height="512pt" viewBox="0 0 512 512" width="512pt"><path d="m316 45c-17.472656 0-33.554688 6.023438-46.316406 16.074219-6.546875-34.71875-37.085938-61.074219-73.683594-61.074219h-136v45h-60v467h512v-467zm0 30h166v287h-166c-16.867188 0-32.457031 5.601562-45 15.035156v-257.035156c0-24.8125 20.1875-45 45-45zm-45 362c0-24.8125 20.1875-45 45-45h166v30h-166c-16.871094 0-32.457031 5.597656-45 15zm-181-407h106c24.8125 0 45 20.1875 45 45v302.035156c-12.542969-9.433594-28.132812-15.035156-45-15.035156h-106zm-30 45v317h136c24.8125 0 45 20.1875 45 45-12.542969-9.402344-28.128906-15-45-15h-166v-347zm-30 377h166c19.554688 0 36.226562 12.539062 42.421875 30h-208.421875zm243.578125 30c6.195313-17.460938 22.867187-30 42.421875-30h166v30zm0 0"/><path d="m452 105h-151v227h151zm-30 197h-91v-167h91zm0 0"/><path d="m211 60h-91v121h91zm-30 91h-31v-61h31zm0 0"/><path d="m211 211h-91v121h91zm-30 91h-31v-61h31zm0 0"/></svg>';
                $item .= '<a href="' . $link . '" class="imgbtn-item--link" title="' . $label . '" target="_blank">' . $linkIcon . '</a>';
            }

            $item .= '<img src="' . $image . '" alt="' . $label . '" title="' . $label . '" /></div>';

            $item .= sprintf(
                '<input %2$s /><span class="wpcf7-list-item-label">%1$s</span>',
                esc_html($label), $item_atts
            );

            $item .= '</label>';

            if (false !== $tabindex
                and 0 < $tabindex) {
                $tabindex += 1;
            }

            $class = 'imgbtn-item wpcf7-list-item';
            $count += 1;

            if ($count == 1) {
                $class .= ' first';
            }

            if (count($tag->values) == $count) { // last round
                $class .= ' last';
            }

            $html .= '<div class="' . esc_attr($class) . '">' . $item . '</div>';
        }

        $html .= '</div>';

        return sprintf(
            '<span class="wpcf7-form-control-wrap %1$s"><span %2$s>%3$s</span>%4$s</span>',
            sanitize_html_class($tag->name), wpcf7_format_atts($atts), $html, $validation_error
        );

    },
        array(
            'name-attr' => true,
            'selectable-values' => true,
            'multiple-controls-container' => true,
        ));

    /**
     * Validation filter
     */
    add_filter('wpcf7_validate_imgbtn*',
        function ($result, $tag) {
            $name = $tag->name;
            $is_required = $tag->is_required() || 'radio' == $tag->type;
            $value = isset($_POST[$name]) ? (array)$_POST[$name] : array();

            if ($is_required and empty($value)) {
                $result->invalidate($tag, wpcf7_get_message('invalid_required'));
            }

            return $result;
        }, 10, 2);

});
