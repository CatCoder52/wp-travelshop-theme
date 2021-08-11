<?php

/**
 * Modal Tag
 */
add_action( 'wpcf7_init', 'custom_add_form_tag_modal');


function custom_add_form_tag_modal() {
    wpcf7_add_form_tag( array('modal'), 'custom_modal_form_tag_handler',
        array(
            'name-attr' => true,
            'selectable-values' => true,
            'multiple-controls-container' => true,
        )); // "clock" is the type of the form-tag
}

function custom_modal_form_tag_handler( $tag ) {
    if ( empty( $tag->name ) ) {
        return '';
    }

    $modalId = null;
    $modalName = $tag->name;

    if ( isset($tag->labels[0]) && !empty($tag->labels[0]) ) {
        $modalId = (int)$tag->labels[0];
    }

    if ( $modalId !== null ) {
        $modalTitle = get_the_title($modalId);
        $modalPageData = get_page($modalId);
        $modalContent = apply_filters('the_content', $modalPageData->post_content);

        $modalHtml = '';

        // -- create modal HTML
        $modalHtml .= '<div class="modal-forms modal-wrapper" id="modal-'.$modalName.'">';
        $modalHtml .= '<div class="modal-inner">';

        $modalHtml .= '<button type="button" class="modal-close"><span></span></button>';

        $modalHtml .= '<div class="modal-body-outer">';
        $modalHtml .= '<div class="modal-body">';

        $modalHtml .= '<div class="h2 modal-title">'.$modalTitle.'</div>';

        $modalHtml .= $modalContent;

        $modalHtml .= '</div>';
        $modalHtml .= '</div>';

        $modalHtml .= '</div>';
        $modalHtml .= '</div>';

        return $modalHtml;

    } else {
        return 'Keine Modal ID angegeben.';
    }
}

/**
 * Motiv Tag
 */
add_action( 'wpcf7_init', 'custom_add_form_tag_motiv');

function custom_add_form_tag_motiv() {
    wpcf7_add_form_tag( array('motiv', 'motiv*'), 'custom_motiv_form_tag_handler',
        array(
            'name-attr' => true,
            'selectable-values' => true,
            'multiple-controls-container' => true,
        )); // "clock" is the type of the form-tag
}

function custom_motiv_form_tag_handler( $tag ) {
    if ( empty( $tag->name ) ) {
        return '';
    }

    $validation_error = wpcf7_get_validation_error( $tag->name );

    $class = wpcf7_form_controls_class( $tag->type );

    if ( $validation_error ) {
        $class .= ' wpcf7-not-valid';
    }

    $label_first = $tag->has_option( 'label_first' );
    $use_label_element = $tag->has_option( 'use_label_element' );
    $exclusive = $tag->has_option( 'exclusive' );
    $free_text = $tag->has_option( 'free_text' );
    $multiple = false;

    if ( 'catalogs' == $tag->basetype ) {
        $multiple = ! $exclusive;
    } else { // radio
        $exclusive = false;
    }

    if ( $exclusive ) {
        $class .= ' wpcf7-exclusive-motiv';
    }

    $atts = array();

    $atts['class'] = $tag->get_class_option( $class );
    $atts['id'] = $tag->get_id_option();

    if ( $validation_error ) {
        $atts['aria-describedby'] = wpcf7_get_validation_error_reference(
            $tag->name
        );
    }

    $tabindex = $tag->get_option( 'tabindex', 'signed_int', true );

    if ( false !== $tabindex ) {
        $tabindex = (int) $tabindex;
    }

    $html = '<div class="motiv-wrapper">';
    $count = 0;

    if ( $data = (array) $tag->get_data_option() ) {
        if ( $free_text ) {
            $tag->values = array_merge(
                array_slice( $tag->values, 0, -1 ),
                array_values( $data ),
                array_slice( $tag->values, -1 ) );
            $tag->labels = array_merge(
                array_slice( $tag->labels, 0, -1 ),
                array_values( $data ),
                array_slice( $tag->labels, -1 ) );
        } else {
            $tag->values = array_merge( $tag->values, array_values( $data ) );
            $tag->labels = array_merge( $tag->labels, array_values( $data ) );
        }
    }

    $values = $tag->values;
    $labels = $tag->labels;

    $default_choice = $tag->get_default_option( null, array(
        'multiple' => $multiple,
    ) );

    $hangover = wpcf7_get_hangover( $tag->name, $multiple ? array() : '' );

    foreach ( $values as $key => $value ) {
        if ( $hangover ) {
            $checked = in_array( $value, (array) $hangover, true );
        } else {
            $checked = in_array( $value, (array) $default_choice, true );
        }

        if ( isset( $labels[$key] ) ) {
            $label = $labels[$key];
        } else {
            $label = $value;
        }

        // -- split label
        $labelArr = explode('::', $label);

        $label = $labelArr[0];
        $image = false;

        if ( isset($labelArr[1]) ) {
            $image = $labelArr[1];
        }

        $item_atts = array(
            'type' => 'radio',
            'name' => $tag->name . ( $multiple ? '[]' : '' ),
            'value' => $label,
            'checked' => $checked ? 'checked' : '',
            'tabindex' => false !== $tabindex ? $tabindex : '',
        );

        $item_atts = wpcf7_format_atts( $item_atts );



        $item = sprintf(
            '<input %2$s /><span class="wpcf7-list-item-label">%1$s</span>',
            esc_html( $label ), $item_atts
        );

        if ( $image == true ) {
            $item = '<div class="motiv-item--image"><img src="'.$image.'" alt="'.$label.'" title="'.$label.'" /></div>' . $item;
        }

        if ( $use_label_element ) {
            $item = '<label>' . $item . '</label>';
        } else  {

            $item = $item ;
        }

        if ( false !== $tabindex
            and 0 < $tabindex ) {
            $tabindex += 1;
        }

        $class = 'motiv-item wpcf7-list-item';
        $count += 1;

        if ( 1 == $count ) {
            $class .= ' first';
        }

        if ( count( $values ) == $count ) { // last round
            $class .= ' last';

            if ( $free_text ) {
                $free_text_name = $tag->name . '_free_text';

                $free_text_atts = array(
                    'name' => $free_text_name,
                    'class' => 'wpcf7-free-text',
                    'tabindex' => false !== $tabindex ? $tabindex : '',
                );

                if ( wpcf7_is_posted()
                    and isset( $_POST[$free_text_name] ) ) {
                    $free_text_atts['value'] = wp_unslash(
                        $_POST[$free_text_name] );
                }

                $free_text_atts = wpcf7_format_atts( $free_text_atts );

                $item .= sprintf( ' <input type="text" %s />', $free_text_atts );

                $class .= ' has-free-text';
            }
        }

        $item = '<div class="' . esc_attr( $class ) . '">' . $item . '</div>';
        $html .= $item;
    }

    $html .= '</div>';

    $atts = wpcf7_format_atts( $atts );

    $html = sprintf(
        '<span class="wpcf7-form-control-wrap %1$s"><span %2$s>%3$s</span>%4$s</span>',
        sanitize_html_class( $tag->name ), $atts, $html, $validation_error
    );

    return $html;
}

/**
 * Catalog Tag
 */
add_action( 'wpcf7_init', 'custom_add_form_tag_catalouge' );

function custom_add_form_tag_catalouge() {
    wpcf7_add_form_tag( array('catalogs', 'catalogs*'), 'custom_catalouge_form_tag_handler',
        array(
            'name-attr' => true,
            'selectable-values' => true,
            'multiple-controls-container' => true,
        )); // "clock" is the type of the form-tag
}

function custom_catalouge_form_tag_handler( $tag ) {
    if ( empty( $tag->name ) ) {
        return '';
    }

    $validation_error = wpcf7_get_validation_error( $tag->name );

    $class = wpcf7_form_controls_class( $tag->type );

    if ( $validation_error ) {
        $class .= ' wpcf7-not-valid';
    }

    $label_first = $tag->has_option( 'label_first' );
    $use_label_element = $tag->has_option( 'use_label_element' );
    $exclusive = $tag->has_option( 'exclusive' );
    $free_text = $tag->has_option( 'free_text' );
    $multiple = false;

    if ( 'catalogs' == $tag->basetype ) {
        $multiple = ! $exclusive;
    } else { // radio
        $exclusive = false;
    }

    if ( $exclusive ) {
        $class .= ' wpcf7-exclusive-catalouge';
    }

    $atts = array();

    $atts['class'] = $tag->get_class_option( $class );
    $atts['id'] = $tag->get_id_option();

    if ( $validation_error ) {
        $atts['aria-describedby'] = wpcf7_get_validation_error_reference(
            $tag->name
        );
    }

    $tabindex = $tag->get_option( 'tabindex', 'signed_int', true );

    if ( false !== $tabindex ) {
        $tabindex = (int) $tabindex;
    }

    $html = '<div class="catalouge-wrapper">';
    $count = 0;

    if ( $data = (array) $tag->get_data_option() ) {
        if ( $free_text ) {
            $tag->values = array_merge(
                array_slice( $tag->values, 0, -1 ),
                array_values( $data ),
                array_slice( $tag->values, -1 ) );
            $tag->labels = array_merge(
                array_slice( $tag->labels, 0, -1 ),
                array_values( $data ),
                array_slice( $tag->labels, -1 ) );
        } else {
            $tag->values = array_merge( $tag->values, array_values( $data ) );
            $tag->labels = array_merge( $tag->labels, array_values( $data ) );
        }
    }

    $values = $tag->values;
    $labels = $tag->labels;

    $default_choice = $tag->get_default_option( null, array(
        'multiple' => $multiple,
    ) );

    $hangover = wpcf7_get_hangover( $tag->name, $multiple ? array() : '' );

    foreach ( $values as $key => $value ) {
        if ( $hangover ) {
            $checked = in_array( $value, (array) $hangover, true );
        } else {
            $checked = in_array( $value, (array) $default_choice, true );
        }

        if ( isset( $labels[$key] ) ) {
            $label = $labels[$key];
        } else {
            $label = $value;
        }

        // -- split label
        $labelArr = explode('::', $label);

        $label = $labelArr[0];
        $image = false;
        $link = false;

        if ( isset($labelArr[1]) ) {
            $image = $labelArr[1];
        }

        if ( isset($labelArr[2]) ) {
            $link = $labelArr[2];
        }

        $item_atts = array(
            'type' => 'checkbox',
            'name' => $tag->name . ( $multiple ? '[]' : '' ),
            'value' => $label,
            'checked' => $checked ? 'checked' : '',
            'tabindex' => false !== $tabindex ? $tabindex : '',
        );

        $item_atts = wpcf7_format_atts( $item_atts );



        $item = sprintf(
            '<input %2$s /><span class="wpcf7-list-item-label">%1$s</span>',
            esc_html( $label ), $item_atts
        );

        if ( $link == true && $image == true ) {
            $linkIcon = '<svg xmlns="http://www.w3.org/2000/svg" height="512pt" viewBox="0 0 512 512" width="512pt"><path d="m316 45c-17.472656 0-33.554688 6.023438-46.316406 16.074219-6.546875-34.71875-37.085938-61.074219-73.683594-61.074219h-136v45h-60v467h512v-467zm0 30h166v287h-166c-16.867188 0-32.457031 5.601562-45 15.035156v-257.035156c0-24.8125 20.1875-45 45-45zm-45 362c0-24.8125 20.1875-45 45-45h166v30h-166c-16.871094 0-32.457031 5.597656-45 15zm-181-407h106c24.8125 0 45 20.1875 45 45v302.035156c-12.542969-9.433594-28.132812-15.035156-45-15.035156h-106zm-30 45v317h136c24.8125 0 45 20.1875 45 45-12.542969-9.402344-28.128906-15-45-15h-166v-347zm-30 377h166c19.554688 0 36.226562 12.539062 42.421875 30h-208.421875zm243.578125 30c6.195313-17.460938 22.867187-30 42.421875-30h166v30zm0 0"/><path d="m452 105h-151v227h151zm-30 197h-91v-167h91zm0 0"/><path d="m211 60h-91v121h91zm-30 91h-31v-61h31zm0 0"/><path d="m211 211h-91v121h91zm-30 91h-31v-61h31zm0 0"/></svg>';
            $item = '<div class="catalouge-item--image"><a href="'.$link.'" class="catalouge-item--link" title="'.$label.'" target="_blank">'.$linkIcon.'</a><img src="'.$image.'" alt="'.$label.'" title="'.$label.'" /></div>' . $item;
        } elseif ( $image == true ) {
            $item = '<div class="catalouge-item--image"><img src="'.$image.'" alt="'.$label.'" title="'.$label.'" /></div>' . $item;
        }

        if ( $use_label_element ) {
            $item = '<label>' . $item . '</label>';
        } else  {

            $item = $item ;
        }

        if ( false !== $tabindex
            and 0 < $tabindex ) {
            $tabindex += 1;
        }

        $class = 'catalouge-item wpcf7-list-item';
        $count += 1;

        if ( 1 == $count ) {
            $class .= ' first';
        }

        if ( count( $values ) == $count ) { // last round
            $class .= ' last';

            if ( $free_text ) {
                $free_text_name = $tag->name . '_free_text';

                $free_text_atts = array(
                    'name' => $free_text_name,
                    'class' => 'wpcf7-free-text',
                    'tabindex' => false !== $tabindex ? $tabindex : '',
                );

                if ( wpcf7_is_posted()
                    and isset( $_POST[$free_text_name] ) ) {
                    $free_text_atts['value'] = wp_unslash(
                        $_POST[$free_text_name] );
                }

                $free_text_atts = wpcf7_format_atts( $free_text_atts );

                $item .= sprintf( ' <input type="text" %s />', $free_text_atts );

                $class .= ' has-free-text';
            }
        }

        $item = '<div class="' . esc_attr( $class ) . '">' . $item . '</div>';
        $html .= $item;
    }

    $html .= '</div>';

    $atts = wpcf7_format_atts( $atts );

    $html = sprintf(
        '<span class="wpcf7-form-control-wrap %1$s"><span %2$s>%3$s</span>%4$s</span>',
        sanitize_html_class( $tag->name ), $atts, $html, $validation_error
    );

    return $html;
}