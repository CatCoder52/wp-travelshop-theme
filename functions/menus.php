<?php

add_action('init', function () {
    $locations = array(
        'primary' => __('Desktop Horizontal Menu', 'travelshop'),
        'expanded' => __('Desktop Expanded Menu', 'travelshop'),
        'ibe_head' => __('IBE Template Head Menu', 'travelshop'),
        'ibe_footer' => __('IBE Template Footer Menu', 'travelshop'),
        'mobile' => __('Mobile Menu', 'travelshop'),
        'footer_column_1' => __('Footer Column 1', 'travelshop'),
        'footer_column_2' => __('Footer Column 2', 'travelshop'),
        'footer_meta_menu' => __('Footer Meta Menu', 'travelshop')
    );

    register_nav_menus($locations);
});


/**
 * Modification of "Build a tree from a flat array in PHP"
 *
 * Authors: @DSkinner, @ImmortalFirefly and @SteveEdson
 *
 * @link https://stackoverflow.com/a/28429487/2078474
 */
function buildTree(array &$elements, $parentId = 0)
{
    global $PMTravelShop;
    $branch = array();
    foreach ($elements as &$element) {
        if ($element->menu_item_parent == $parentId) {
            $children = buildTree($elements, $element->ID);
            if ($children) {
                $element->wpse_children = $children;
            }

            // if the menu type object is based on pressmind category trees,
            // we have to get these items and mix it in the tree
            if($element->object == 'pmt2core_category_trees'){
                $id_tree = $element->object_id;

                // we have to use the xfn field for storing pressmind specific informations, not the best,
                // but a working way. wordpress docu see also add_menu_meta.php which writes into the xfn field.
                list($id_object_type, $var_name) = explode(' ', $element->xfn);

                $search = new Pressmind\Search(
                    [
                        Pressmind\Search\Condition\Visibility::create(TS_VISIBILTY),
                        Pressmind\Search\Condition\ObjectType::create($id_object_type),
                    ]
                );
                $tree = new Pressmind\Search\Filter\Category($id_tree, $search);
                $treeItems = $tree->getResult();

                if(empty($treeItems) === false){
                    $element->wpse_children = [];
                    foreach($treeItems as $item){
                        $tmp = new stdClass();
                        $tmp->url =  site_url() . '/' . Pressmind\Travelshop\RouteHelper::get_url_by_object_type($id_object_type) . '/?pm-c['.$var_name.']='.$item->id;
                        $tmp->title = $item->name;
                        $element->wpse_children[] = $tmp;
                    }
                }

            }

            $branch[$element->ID] = $element;
            unset($element);
        }
    }
    return $branch;
}


/**
 * Transform a navigational menu to it's tree structure
 * @param string $menu_position
 * @return array|null $tree
 * @uses buildTree()
 * @uses wp_get_nav_menu_items()
 */
function nav_menu_2_tree($menu_position)
{
    $locations = get_nav_menu_locations(); //get all menu locations
    $primary = wp_get_nav_menu_object($locations[$menu_position]);
    $items = wp_get_nav_menu_items($primary);
    return $items ? buildTree($items, 0) : null;
}