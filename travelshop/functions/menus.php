<?php

add_action( 'init', function () {
    $locations = array(
        'primary'  => __( 'Desktop Horizontal Menu', 'travelshop' ),
        'expanded' => __( 'Desktop Expanded Menu', 'travelshop' ),
        'ibe_head' => __( 'IBE Template Head Menu', 'travelshop' ),
        'ibe_footer' => __( 'IBE Template Footer Menu', 'travelshop' ),
        'mobile'   => __( 'Mobile Menu', 'travelshop' ),
        'footer_column_1'   => __( 'Footer Column 1', 'travelshop' ),
        'footer_column_2'   => __( 'Footer Column 2', 'travelshop' ),
    );

    register_nav_menus( $locations );
});


/**
 * Modification of "Build a tree from a flat array in PHP"
 *
 * Authors: @DSkinner, @ImmortalFirefly and @SteveEdson
 *
 * @link https://stackoverflow.com/a/28429487/2078474
 */
function buildTree( array &$elements, $parentId = 0 )
{
    $branch = array();
    foreach ( $elements as &$element )
    {
        if ( $element->menu_item_parent == $parentId )
        {
            $children = buildTree( $elements, $element->ID );
            if ( $children )
                $element->wpse_children = $children;

            $branch[$element->ID] = $element;
            unset( $element );
        }
    }
    return $branch;
}


/**
 * @todo wpse?!
 * Transform a navigational menu to it's tree structure
 *
 * @uses  buildTree()
 * @uses  wp_get_nav_menu_items()
 *
 * @param  String     $menu_position
 * @return Array|null $tree
 */
function wpse_nav_menu_2_tree( $menu_position )
{

    $locations = get_nav_menu_locations(); //get all menu locations
    $primary = wp_get_nav_menu_object($locations[$menu_position]);

    $items = wp_get_nav_menu_items($primary);

    return  $items ? buildTree( $items, 0 ) : null;
}