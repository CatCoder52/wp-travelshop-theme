<?php

namespace Custom\MediaType;

use Pressmind\ORM\Object\MediaType\AbstractMediaType;
use Pressmind\ORM\Object\MediaObject\DataType;
use DateTime;

/**
 * Class Reise
 * @property integer $id
 * @property integer $id_media_object
 * @property string $language
 * @property DataType\Categorytree[] $sterne_default
 * @property DataType\Categorytree[] $highlights_default
 * @property DataType\Categorytree[] $gtxf_destination_default
 * @property DataType\Categorytree[] $gtxf_reiseart_default
 * @property DataType\Key_value[] $key_value_default
 * @property DataType\Objectlink[] $unterkunftsverknuepfung_default
 * @property string $prrovisionsverzicht_default
 * @property DataType\Categorytree[] $optionen_default
 * @property DataType\Link[] $video_default
 * @property DataType\Objectlink[] $veranstalter_default
 * @property DataType\Picture[] $bilder_default
 * @property DataType\Picture[] $karte_default
 * @property string $title_default
 * @property string $headline_michael_test
 * @property string $headline_default
 * @property string $leistungen_headline_default
 * @property DataType\Categorytree[] $reiseart_default
 * @property DateTime $datum_default
 * @property DataType\Location[] $googlemaps_default
 * @property string $meta_description_default
 * @property string $subline_default
 * @property string $leistungen_default
 * @property DataType\Categorytree[] $befoerderung_default
 * @property DataType\Categorytree[] $saison_default
 * @property DataType\Objectlink[] $unterkunftsbeschreibungen_default
 * @property string $meta_keywords_default
 * @property string $einleitung_default
 * @property DataType\Categorytree[] $zielgebiet_default
 * @property DataType\Objectlink[] $touristic_module_default
 * @property string $meta_robots_default
 * @property string $beschreibung_headline_default
 * @property DataType\Categorytree[] $stoerer_default
 * @property DataType\File[] $upload_default
 * @property string $meta_revisit_default
 * @property string $beschreibung_text_default
 * @property DataType\Categorytree[] $veranstalterzuordnung_default
 * @property string $header_source_code_default
 * @property string $meta_canonical_default
 * @property DataType\Table[] $tabelle_default
 * @property DataType\Categorytree[] $vertriebsportale_default
 * @property DataType\Objectlink[] $textbaustein_default
 * @property string $footer_source_code_default
 * @property DataType\Categorytree[] $website_ausgabe_default
 * @property string $url_default
 * @property DataType\Objectlink[] $url_verknuepfung_default
 * @property string $referenz_auf_sektion_default
 * @property string $referenz_auf_sektion_default_longtext
 * @property DataType\Categorytree[] $travelfeed_default
 */
class Reise extends AbstractMediaType {
protected $_definitions = [
    'class' => [
        'name' => 'Reise',
    ],
    'database' => [
        'table_name' => 'objectdata_607',
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
        'highlights_default' => [
            'name' => 'highlights_default',
            'title' => 'highlights_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'highlights_default',
                ],
            ],
        ],
        'gtxf_destination_default' => [
            'name' => 'gtxf_destination_default',
            'title' => 'gtxf_destination_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'gtxf_destination_default',
                ],
            ],
        ],
        'gtxf_reiseart_default' => [
            'name' => 'gtxf_reiseart_default',
            'title' => 'gtxf_reiseart_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'gtxf_reiseart_default',
                ],
            ],
        ],
        'key_value_default' => [
            'name' => 'key_value_default',
            'title' => 'key_value_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Key_value',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'key_value_default',
                ],
            ],
        ],
        'unterkunftsverknuepfung_default' => [
            'name' => 'unterkunftsverknuepfung_default',
            'title' => 'unterkunftsverknuepfung_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Objectlink',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'unterkunftsverknuepfung_default',
                ],
            ],
        ],
        'prrovisionsverzicht_default' => [
            'name' => 'prrovisionsverzicht_default',
            'title' => 'prrovisionsverzicht_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'optionen_default' => [
            'name' => 'optionen_default',
            'title' => 'optionen_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'optionen_default',
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
        'veranstalter_default' => [
            'name' => 'veranstalter_default',
            'title' => 'veranstalter_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Objectlink',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'veranstalter_default',
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
        'karte_default' => [
            'name' => 'karte_default',
            'title' => 'karte_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Picture',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'karte_default',
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
        'headline_michael_test' => [
            'name' => 'headline_michael_test',
            'title' => 'headline_michael_test',
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
        'leistungen_headline_default' => [
            'name' => 'leistungen_headline_default',
            'title' => 'leistungen_headline_default',
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
        'datum_default' => [
            'name' => 'datum_default',
            'title' => 'datum_default',
            'type' => 'datetime',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
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
        'meta_description_default' => [
            'name' => 'meta_description_default',
            'title' => 'meta_description_default',
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
        'leistungen_default' => [
            'name' => 'leistungen_default',
            'title' => 'leistungen_default',
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
        'unterkunftsbeschreibungen_default' => [
            'name' => 'unterkunftsbeschreibungen_default',
            'title' => 'unterkunftsbeschreibungen_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Objectlink',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'unterkunftsbeschreibungen_default',
                ],
            ],
        ],
        'meta_keywords_default' => [
            'name' => 'meta_keywords_default',
            'title' => 'meta_keywords_default',
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
        'touristic_module_default' => [
            'name' => 'touristic_module_default',
            'title' => 'touristic_module_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Objectlink',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'touristic_module_default',
                ],
            ],
        ],
        'meta_robots_default' => [
            'name' => 'meta_robots_default',
            'title' => 'meta_robots_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'beschreibung_headline_default' => [
            'name' => 'beschreibung_headline_default',
            'title' => 'beschreibung_headline_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'stoerer_default' => [
            'name' => 'stoerer_default',
            'title' => 'stoerer_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'stoerer_default',
                ],
            ],
        ],
        'upload_default' => [
            'name' => 'upload_default',
            'title' => 'upload_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\File',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'upload_default',
                ],
            ],
        ],
        'meta_revisit_default' => [
            'name' => 'meta_revisit_default',
            'title' => 'meta_revisit_default',
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
        'header_source_code_default' => [
            'name' => 'header_source_code_default',
            'title' => 'header_source_code_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'meta_canonical_default' => [
            'name' => 'meta_canonical_default',
            'title' => 'meta_canonical_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'tabelle_default' => [
            'name' => 'tabelle_default',
            'title' => 'tabelle_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Table',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'tabelle_default',
                ],
            ],
        ],
        'vertriebsportale_default' => [
            'name' => 'vertriebsportale_default',
            'title' => 'vertriebsportale_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'vertriebsportale_default',
                ],
            ],
        ],
        'textbaustein_default' => [
            'name' => 'textbaustein_default',
            'title' => 'textbaustein_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Objectlink',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'textbaustein_default',
                ],
            ],
        ],
        'footer_source_code_default' => [
            'name' => 'footer_source_code_default',
            'title' => 'footer_source_code_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'website_ausgabe_default' => [
            'name' => 'website_ausgabe_default',
            'title' => 'website_ausgabe_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'website_ausgabe_default',
                ],
            ],
        ],
        'url_default' => [
            'name' => 'url_default',
            'title' => 'url_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'url_verknuepfung_default' => [
            'name' => 'url_verknuepfung_default',
            'title' => 'url_verknuepfung_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Objectlink',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'url_verknuepfung_default',
                ],
            ],
        ],
        'referenz_auf_sektion_default' => [
            'name' => 'referenz_auf_sektion_default',
            'title' => 'referenz_auf_sektion_default',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'referenz_auf_sektion_default_longtext' => [
            'name' => 'referenz_auf_sektion_default_longtext',
            'title' => 'referenz_auf_sektion_default_longtext',
            'type' => 'string',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
        ],
        'travelfeed_default' => [
            'name' => 'travelfeed_default',
            'title' => 'travelfeed_default',
            'type' => 'relation',
            'required' => false,
            'validators' => NULL,
            'filters' => NULL,
            'relation' => [
                'type' => 'hasMany',
                'class' => '\\Pressmind\\ORM\\Object\\MediaObject\\DataType\\Categorytree',
                'related_id' => 'id_media_object',
                'filters' => [
                    'var_name' => 'travelfeed_default',
                ],
            ],
        ],
    ],
];}