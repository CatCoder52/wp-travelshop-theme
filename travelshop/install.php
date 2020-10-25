<?php
/**
 * This is a composer pre installation script
 * it's set some tricky path around the WordPress Environment
 */

ini_set('display_errors', 'On');
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Init
if (php_sapi_name() !== 'cli') {
    die("Meant to be run from command line");
}

$config_dir = "vendor/pressmind/lib/";

if(file_exists($config_dir.'config.json')){
    echo "config.json already exists in ".$config_dir.". Installation aborted.\r\n";
    exit();
}

/**
 * @var $Config
 */
$Config = json_decode(file_get_contents($config_dir."config.json.default"));

// Setup the Preview URL
$Config->development->data->preview_url = "\/examples\/detail.php?id={{id_media_object}}&preview={{preview}}";

// Setup some Pathes, all relative to to pressmind lib
$Config->development->view_scripts->base_path = "../../../template-parts/pm-views";
$Config->development->file_download->download_file_path = "../../../../../uploads/pressmind/downloads";

// Setup Scaffolder Templates
$Config->development->scaffolder_templates->overwrite_existing_templates = false;
$Config->development->scaffolder_templates->base_path = "../../../template-parts/pm-views/scaffolder";

// Image Processor
$Config->development->imageprocessor->image_file_path = "../../../../../uploads/pressmind/images";
$Config->development->imageprocessor->image_http_path = "/wp-content/uploads/pressmind/images/";

// Enable WebPicture Support
$Config->development->imageprocessor->webp_support = true;

// Setup Image Derivatives
$Config->development->imageprocessor->derivatives->teaser = new stdClass();
$Config->development->imageprocessor->derivatives->teaser->max_width = 250;
$Config->development->imageprocessor->derivatives->teaser->max_height = 170;
$Config->development->imageprocessor->derivatives->teaser->preserve_aspect_ratio = true;
$Config->development->imageprocessor->derivatives->teaser->crop = true;
$Config->development->imageprocessor->derivatives->teaser->horizontal_crop =  "center";
$Config->development->imageprocessor->derivatives->teaser->vertical_crop =  "center";
$Config->development->imageprocessor->derivatives->teaser->webp_create =  true;
$Config->development->imageprocessor->derivatives->teaser->webp_quality =  80;


$Config->development->imageprocessor->derivatives->detail_thumb = new stdClass();
$Config->development->imageprocessor->derivatives->detail_thumb->max_width = 180;
$Config->development->imageprocessor->derivatives->detail_thumb->max_height = 180;
$Config->development->imageprocessor->derivatives->detail_thumb->preserve_aspect_ratio = true;
$Config->development->imageprocessor->derivatives->detail_thumb->crop = true;
$Config->development->imageprocessor->derivatives->detail_thumb->horizontal_crop =  "center";
$Config->development->imageprocessor->derivatives->detail_thumb->vertical_crop =  "center";
$Config->development->imageprocessor->derivatives->detail_thumb->webp_create =  true;
$Config->development->imageprocessor->derivatives->detail_thumb->webp_quality =  80;

$Config->development->imageprocessor->derivatives->detail = new stdClass();
$Config->development->imageprocessor->derivatives->detail->max_width = 610;
$Config->development->imageprocessor->derivatives->detail->max_height = 385;
$Config->development->imageprocessor->derivatives->detail->preserve_aspect_ratio = true;
$Config->development->imageprocessor->derivatives->detail->crop = true;
$Config->development->imageprocessor->derivatives->detail->horizontal_crop =  "center";
$Config->development->imageprocessor->derivatives->detail->vertical_crop =  "center";
$Config->development->imageprocessor->derivatives->detail->webp_create =  true;
$Config->development->imageprocessor->derivatives->detail->webp_quality =  80;


// Save
if(file_put_contents($config_dir."config.json", json_encode($Config, JSON_PRETTY_PRINT)) > 0){
    echo "Installation completed\r\n";
    echo "Please enter database and pressmind-api credentials in ".__DIR__."/vendor/pressmind/lib/config.json manually\r\n";
}



