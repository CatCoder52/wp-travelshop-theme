<?php

use Pressmind\HelperFunctions;
use Pressmind\Log\Writer;
use Pressmind\ORM\Object\MediaObject\DataType\File;
use Pressmind\Registry;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

Writer::write('File downloader started', WRITER::OUTPUT_FILE, 'file_downloader', Writer::TYPE_INFO);

$db = Registry::getInstance()->get('db');
$config = Registry::getInstance()->get('config');

$result = File::listAll(['download_successful' => 0]);

Writer::write('Downloading ' . count($result) . ' files', WRITER::OUTPUT_FILE, 'file_downloader', Writer::TYPE_INFO);

/** @var File $file */
foreach ($result as $file) {
    try {
        Writer::write('Downloading file from ' . $file->tmp_url, WRITER::OUTPUT_FILE, 'file_downloader', Writer::TYPE_INFO);
        $file->downloadOriginal();
        Writer::write('File downloaded to ' . HelperFunctions::replaceConstantsFromConfig($config['file_handling']['storage']['bucket']) . '/' . $file->file_name, WRITER::OUTPUT_FILE, 'file_downloader', Writer::TYPE_INFO);
    } catch (Exception $e) {
        Writer::write($e->getMessage(), WRITER::OUTPUT_FILE, 'file_downloader', Writer::TYPE_ERROR);
    }
}
