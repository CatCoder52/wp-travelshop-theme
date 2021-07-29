<?php
// webcore config, webcore db, beaverbuilder settings
global $config, $db, $settings;

/*
// Default Settings
$defaults = array(
    'pm-ot' => array_key_first($config['data']['primary_media_type_ids']),

);

$tab_defaults = isset($tab['defaults']) ? $tab['defaults'] : array();
$settings = (object)array_merge($defaults, $tab_defaults, (array)$settings);
*/


// get all categories group by id objec type for later purposes
$r = $db->fetchAll('select distinct var_name, ti.id_tree as id, ct.name, id_object_type from pmt2core_media_object_tree_items ti
                            left join pmt2core_media_objects mo on(mo.id = ti.id_media_object)
                            left join pmt2core_category_trees ct on (ct.id = ti.id_tree)
                            order by ct.name asc');
$categories = [];
foreach ($r as $category){
    $category->fieldname = 'category_'.$category->id_object_type.'_'.$category->id.'-'.$category->var_name;
    $categories[] = $category;
}

?>

<div class="fl-custom-query fl-loop-data-source" data-source="filter">

    <div id="fl-builder-settings-section-general" class="fl-builder-settings-section">
        <div class="fl-builder-settings-section-header">
            <button class="fl-builder-settings-title">
                <svg class="fl-symbol">
                    <use xlink:href="#fl-down-caret"></use>
                </svg>
                Type
            </button>
        </div>
        <div class="fl-builder-settings-section-content">
            <table class="fl-form-table">
                <?php
                // get all possible view files and group by object_type
                $view_options =  [];
                $script_path = str_replace('APPLICATION_PATH', APPLICATION_PATH, $config['view_scripts']['base_path']);
                foreach(glob($script_path.'/*.php') as $file){
                    $file = basename($file, '.php');
                    list($object_name, $view_name) = explode('_', $file);
                    $id_object_type = array_search($object_name, $config['data']['media_types']);
                    $view_options[$id_object_type][$view_name] = $view_name;
                }


                $toggle = [];
                // toggle media object type specific views
                foreach($config['data']['media_types'] as $id => $type){
                    $toggle[$id]['fields'][] = 'view_'.$id;
                }

                // toggle media object type specific category fields
                foreach($categories as $id => $category){
                        $toggle[$category->id_object_type]['fields'][] = $category->fieldname;
                }

                FLBuilder::render_settings_field('pm-ot', array(
                    'type' => 'select',
                    'label' => 'Object Type',
                    'default' => array_key_first($config['data']['primary_media_type_ids']),
                    'options' => $config['data']['media_types'],
                    'toggle' => $toggle
                ), $settings);

                // View by object type
                foreach($config['data']['media_types'] as $id => $type){

                    FLBuilder::render_settings_field('view_'.$id, array(
                        'type' => 'select',
                        'label' => 'View for '.$id,
                        'default' => 'Teaser1',
                        'options' => $view_options[$id],
                    ), $settings);

                }
                ?>
            </table>
        </div>
    </div>

    <div id="fl-builder-settings-section-pagination" class="fl-builder-settings-section fl-builder-settings-section-collapsed">
        <div class="fl-builder-settings-section-header">
            <button class="fl-builder-settings-title">
                <svg class="fl-symbol">
                    <use xlink:href="#fl-down-caret"></use>
                </svg>
                Pagination
            </button>
        </div>
        <div class="fl-builder-settings-section-content">
            <table class="fl-form-table">
                <?php
                // Limit
                FLBuilder::render_settings_field('items_per_page', array(
                    'type' => 'unit',
                    'label' => 'Items per page',
                    'default' => '6',
                    'placeholder' => '6',
                    'sanitize' => 'absint',
                    'slider' => array(
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ),
                ), $settings);

                // Offset
                FLBuilder::render_settings_field('page', array(
                    'type' => 'unit',
                    'label' => 'Page',
                    'default' => '0',
                    'placeholder' => '0',
                    'sanitize' => 'absint',
                    'slider' => array(
                        'min' => 0,
                        'max' => 100,
                        'step' => 2,
                    ),
                ), $settings);
                ?>
            </table>
        </div>
    </div>
    <div id="fl-builder-settings-section-order" class="fl-builder-settings-section fl-builder-settings-section-collapsed">
        <div class="fl-builder-settings-section-header">
            <button class="fl-builder-settings-title">
                <svg class="fl-symbol">
                    <use xlink:href="#fl-down-caret"></use>
                </svg>
                Order
            </button>
        </div>
        <div class="fl-builder-settings-section-content">
            <table class="fl-form-table">
                <?php
                // Order
                FLBuilder::render_settings_field('order', array(
                    'type' => 'select',
                    'label' => __('Order', 'fl-builder'),
                    'options' => array(
                        'desc' => __('Descending', 'fl-builder'),
                        'asc' => __('Ascending', 'fl-builder'),
                    ),
                ), $settings);

                // Order By
                FLBuilder::render_settings_field('order_by', array(
                    'type' => 'select',
                    'label' => __('Order', 'fl-builder'),
                    'options' => array(
                        '' => '-',
                        'price' => 'price',
                        'name' => 'name',
                        'code' => 'code',
                        'rand' => 'random',
                    ),
                ), $settings);
                ?>
            </table>
        </div>
    </div>
    <div id="fl-builder-settings-section-basic" class="fl-builder-settings-section fl-builder-settings-section-collapsed">
        <div class="fl-builder-settings-section-header">
            <button class="fl-builder-settings-title">
                <svg class="fl-symbol">
                    <use xlink:href="#fl-down-caret"></use>
                </svg>
                Basis filter
            </button>
        </div>
        <div class="fl-builder-settings-section-content">
            <table class="fl-form-table">
                <?php

                FLBuilder::render_settings_field('pm-po', array(
                    'type' => 'text',
                    'label' => 'Pool',
                    'default' => '',
                    'placeholder' => '123,124'

                ), $settings);

                FLBuilder::render_settings_field('pm-t', array(
                    'type' => 'text',
                    'label' => 'Keyword',
                    'default' => '',
                ), $settings);

                ?>
            </table>
        </div>
    </div>
    <div id="fl-builder-settings-section-states" class="fl-builder-settings-section fl-builder-settings-section-collapsed">
        <div class="fl-builder-settings-section-header">
            <button class="fl-builder-settings-title">
                <svg class="fl-symbol">
                    <use xlink:href="#fl-down-caret"></use>
                </svg>
                Visibility &amp; State
            </button>
        </div>
        <div class="fl-builder-settings-section-content">
            <table class="fl-form-table">
                <?php
                FLBuilder::render_settings_field('pm-vi', array(
                    'type' => 'select',
                    'label' => 'Visibility',
                    'default' => '30',
                    'multiple' => true,
                    'options' => array(
                        '-' => '-',
                        '10' => 'Nobody',
                        '30' => 'Public',
                        '40' => 'Extranet',
                        '50' => 'Intranet',
                        '60' => 'Hidden',
                    ),
                ), $settings);

                ?>
            </table>
        </div>
    </div>
    <!-- this id is used to identify the section for toggling fl-builder-settings-section-SECTIONID -->
    <div id="fl-builder-settings-section-categories" class="fl-builder-settings-section fl-builder-settings-section-collapsed">
        <div class="fl-builder-settings-section-header">
            <button class="fl-builder-settings-title">
                <svg class="fl-symbol">
                    <use xlink:href="#fl-down-caret"></use>
                </svg>
                Categories
            </button>
        </div>
        <div class="fl-builder-settings-section-content">
            <table class="fl-form-table">
                <?php
                foreach($categories as $category){
                    FLBuilder::render_settings_field($category->fieldname, array(
                        'type' => 'suggest',
                        'action' => $category->fieldname,
                        'data' => 'categorytree',
                        'label' => $category->var_name,
                        'help' => '',
                        'matching' => false,
                    ), $settings);
                }
                ?>
            </table>
        </div>
    </div>
</div>

