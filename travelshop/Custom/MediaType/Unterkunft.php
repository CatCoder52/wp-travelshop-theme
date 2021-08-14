<?php

namespace Custom\MediaType;

use Pressmind\ORM\Object\MediaType\AbstractMediaType;
use Pressmind\ORM\Object\MediaObject\DataType;

/**
 * Class Unterkunft
 * @property integer $id
 * @property integer $id_media_object
 * @property string $language
 * @property DataType\Categorytree[] $zielgebiet_default
 * @property DataType\Picture[] $bilder_default
 * @property string $title_default
 * @property string $headline_default
 * @property string $meta_description_default
 * @property string $einleitung_default
 * @property string $beschreibung_text_default
 * @property DataType\Categorytree[] $sterne_default
 * @property DataType\Categorytree[] $sterne_category_tag
 */
class Unterkunft extends AbstractMediaType {
protected $_definitions = [
    'class' => [
        'name' => 'Unterkunft',
    ],
    'database' => [
        'table_name' => 'objectdata_608',
        'primary_key' => 'id',
        'relation_key' => 'id_media_object',
    ],
    'properties' => [
        'id' => [
            'name' => 'id',
            'title' => 'id',
            'type' => 'integer',
            'required' => true,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'id_media_object' => [
            'name' => 'id_media_object',
            'title' => 'id_media_object',
            'type' => 'integer',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'index' => [
                'id_media_object' => 'index',
            ],
        ],
        'language' => [
            'name' => 'language',
            'title' => 'language',
            'type' => 'string',
            'required' => false,
            'validators' => [
                0 => [
                    'name' => 'maxlength',
                    'params' => 255,
                ],
            ],
            'filters' => NULL,
            'index' => [
                'language' => 'index',
            ],
        ],
        'zielgebiet_default' => [
            'name' => 'zielgebiet_default',
            'title' => 'zielgebiet_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'zielgebiet_default',
                ],
            ],
        ],
        'bilder_default' => [
            'name' => 'bilder_default',
            'title' => 'bilder_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Picture',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'bilder_default',
                    'section_name' => 'IS NULL',
                ],
            ],
        ],
        'title_default' => [
            'name' => 'title_default',
            'title' => 'title_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'headline_default' => [
            'name' => 'headline_default',
            'title' => 'headline_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'meta_description_default' => [
            'name' => 'meta_description_default',
            'title' => 'meta_description_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'einleitung_default' => [
            'name' => 'einleitung_default',
            'title' => 'einleitung_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'beschreibung_text_default' => [
            'name' => 'beschreibung_text_default',
            'title' => 'beschreibung_text_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'sterne_default' => [
            'name' => 'sterne_default',
            'title' => 'sterne_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'sterne_default',
                ],
            ],
        ],
        'sterne_category_tag' => [
            'name' => 'sterne_category_tag',
            'title' => 'sterne_category_tag',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'sterne_category_tag',
                ],
            ],
        ],
    ],
];}