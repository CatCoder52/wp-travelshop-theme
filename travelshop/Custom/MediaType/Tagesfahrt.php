<?php

namespace Custom\MediaType;

use Pressmind\ORM\Object\MediaType\AbstractMediaType;
use Pressmind\ORM\Object\MediaObject\DataType;

/**
 * Class Tagesfahrt
 * @property integer $id
 * @property integer $id_media_object
 * @property string $language
 * @property DataType\Categorytree[] $saison_default
 * @property DataType\Link[] $video_default
 * @property DataType\Location[] $googlemaps_default
 * @property DataType\Picture[] $bilder_default
 * @property string $meta_description_default
 * @property string $headline_default
 * @property DataType\Categorytree[] $zielgebiet_default
 * @property string $title_default
 * @property string $subline_default
 * @property DataType\Categorytree[] $reiseart_default
 * @property string $beschreibung_headline_default
 * @property DataType\Categorytree[] $befoerderung_default
 * @property DataType\Categorytree[] $veranstalterzuordnung_default
 * @property string $beschreibung_text_default
 * @property string $leistungen_headline_default
 * @property string $leistungen_default
 */
class Tagesfahrt extends AbstractMediaType {
protected $_definitions = [
    'class' => [
        'name' => 'Tagesfahrt',
    ],
    'database' => [
        'table_name' => 'objectdata_609',
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
        'saison_default' => [
            'name' => 'saison_default',
            'title' => 'saison_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'saison_default',
                ],
            ],
        ],
        'video_default' => [
            'name' => 'video_default',
            'title' => 'video_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Link',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'video_default',
                ],
            ],
        ],
        'googlemaps_default' => [
            'name' => 'googlemaps_default',
            'title' => 'googlemaps_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Location',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'googlemaps_default',
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
        'meta_description_default' => [
            'name' => 'meta_description_default',
            'title' => 'meta_description_default',
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
        'title_default' => [
            'name' => 'title_default',
            'title' => 'title_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'subline_default' => [
            'name' => 'subline_default',
            'title' => 'subline_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'reiseart_default' => [
            'name' => 'reiseart_default',
            'title' => 'reiseart_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'reiseart_default',
                ],
            ],
        ],
        'beschreibung_headline_default' => [
            'name' => 'beschreibung_headline_default',
            'title' => 'beschreibung_headline_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'befoerderung_default' => [
            'name' => 'befoerderung_default',
            'title' => 'befoerderung_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'befoerderung_default',
                ],
            ],
        ],
        'veranstalterzuordnung_default' => [
            'name' => 'veranstalterzuordnung_default',
            'title' => 'veranstalterzuordnung_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'veranstalterzuordnung_default',
                ],
            ],
        ],
        'beschreibung_text_default' => [
            'name' => 'beschreibung_text_default',
            'title' => 'beschreibung_text_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'leistungen_headline_default' => [
            'name' => 'leistungen_headline_default',
            'title' => 'leistungen_headline_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'leistungen_default' => [
            'name' => 'leistungen_default',
            'title' => 'leistungen_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
    ],
];}