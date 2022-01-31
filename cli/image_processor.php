<?php
namespace Pressmind;

use Exception;
use ImagickException;
use Pressmind\Image\Processor\Adapter\Factory;
use Pressmind\Image\Processor\Config;
use Pressmind\Log\Writer;
use Pressmind\ORM\Object\Itinerary\Step\DocumentMediaObject;
use Pressmind\ORM\Object\MediaObject\DataType\Picture;
use \Pressmind\Search\MongoDB\Indexer;
if(php_sapi_name() == 'cli') {
    putenv('ENV=DEVELOPMENT');
}

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

$args = $argv;
$args[1] = isset($argv[1]) ? $argv[1] : null;

$config = Registry::getInstance()->get('config');

Writer::write('Image processor started', WRITER::OUTPUT_FILE, 'image_processor', Writer::TYPE_INFO);

try {
    /** @var Picture[] $result */
    $result =  array_merge(
        Picture::listAll(array('download_successful' => 0)),
        DocumentMediaObject::listAll(array('download_successful' => 0))
    );
} catch (Exception $e) {
    Writer::write($e->getMessage(), WRITER::OUTPUT_BOTH, 'image_processor', Writer::TYPE_ERROR);
}

Writer::write('Processing ' . count($result) . ' images', WRITER::OUTPUT_BOTH, 'image_processor', Writer::TYPE_INFO);

$id_media_objects = [];
foreach ($result as $image) {

    if(!empty($image->id_media_object)){ // @TODO build this for DocumentMediaObject (no id_media_object is directly present in this case)
        $id_media_objects[] = $image->id_media_object;
    }
    $binary_image = null;
    Writer::write('Processing image ID:' . $image->getId(), WRITER::OUTPUT_BOTH, 'image_processor', Writer::TYPE_INFO);
    Writer::write('Downloading image from ' . $image->tmp_url, WRITER::OUTPUT_BOTH, 'image_processor', Writer::TYPE_INFO);
    try {
        $binary_image = $image->downloadOriginal();
    } catch (Exception $e) {
        Writer::write($e->getMessage(), WRITER::OUTPUT_BOTH, 'image_processor', Writer::TYPE_ERROR);
        continue;
    }
    $imageProcessor = Factory::create($config['image_handling']['processor']['adapter']);
    Writer::write('Creating derivatives', WRITER::OUTPUT_BOTH, 'image_processor', Writer::TYPE_INFO);
    foreach ($config['image_handling']['processor']['derivatives'] as $derivative_name => $derivative_config) {
        try {
            Writer::write('Creating derivative: '.$derivative_name, WRITER::OUTPUT_BOTH, 'image_processor', Writer::TYPE_INFO);

            $processor_config = Config::create($derivative_name, $derivative_config);
            $image->createDerivative($processor_config, $imageProcessor, $binary_image);
            Writer::write('Processing sections', WRITER::OUTPUT_FILE, 'image_processor', Writer::TYPE_INFO);
        } catch (Exception $e) {
            Writer::write($e->getMessage(), WRITER::OUTPUT_BOTH, 'image_processor', Writer::TYPE_ERROR);
            continue;
        }
        foreach ($image->sections as $section) {
            Writer::write('Downloading section image from ' . $section->tmp_url, WRITER::OUTPUT_FILE, 'image_processor', Writer::TYPE_INFO);
            try {
                $binary_section_file = $section->downloadOriginal();
                Writer::write('Creating section image derivatives', WRITER::OUTPUT_FILE, 'image_processor', Writer::TYPE_INFO);
                $section->createDerivative($processor_config, $imageProcessor, $binary_section_file);
                unset($binary_section_file);
            } catch (Exception $e) {
                Writer::write($e->getMessage(), WRITER::OUTPUT_BOTH, 'image_processor', Writer::TYPE_ERROR);
                continue;
            }
        }
    }
    unset($binary_image);
}

if(!empty($id_media_objects)){
    Writer::write('Update MongoDB Index (new urls are present)', WRITER::OUTPUT_SCREEN, 'image_processor', Writer::TYPE_INFO);
    $id_media_objects = array_unique($id_media_objects);
    $Indexer = new Indexer();
    $Indexer->upsertMediaObject($id_media_objects);
    Writer::write('updated', WRITER::OUTPUT_SCREEN, 'image_processor', Writer::TYPE_INFO);
}

Writer::write('Image processor finished', WRITER::OUTPUT_FILE, 'image_processor', Writer::TYPE_INFO);
