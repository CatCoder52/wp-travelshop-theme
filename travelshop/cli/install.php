<?php
namespace Pressmind;
use Exception;
use Pressmind\Log\Writer;
use Pressmind\ORM\Object\Scheduler\Task;
use Pressmind\REST\Client;
use Pressmind\System\Info;

if (php_sapi_name() !== 'cli') {
    die("This file is meant to be run from command line");
}

$first_install = !file_exists(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'pm-config.php');

if($first_install) {
    $sdk_directory = dirname(__DIR__)
        . DIRECTORY_SEPARATOR
        . 'vendor'
        . DIRECTORY_SEPARATOR
        . 'pressmind'
        . DIRECTORY_SEPARATOR
        . 'sdk';
    if(!is_dir($sdk_directory)) {
        echo "ERROR!\n";
        echo "pressmind sdk seems not to be installed. Please run 'composer install' in " . dirname(__DIR__) . " to install all required dependencies before running this script\n";
        die();
    }

    echo "Welcome to the initial installation of your new pressmind web-core project.\n";
    echo "Please enter some initial configuration data.\n";

    $default_config_file = $sdk_directory . DIRECTORY_SEPARATOR . 'config.default.json';

    $config = json_decode(file_get_contents($default_config_file), true);

    $db_host = readline("Enter Database Host [127.0.0.1]: ");
    $db_port = readline("Enter Database Port [3306]: ");
    $db_name = readline("Enter Database Name: ");
    $db_user = readline("Enter Database Username: ");
    $db_password = readline("Enter Database User Password: ");
    $pressmind_api_key = readline("Enter Pressmind API Key: ");
    $pressmind_api_user = readline("Enter Pressmind API User: ");
    $pressmind_api_password = readline("Enter Pressmind API Password: ");

    if(empty($db_host)) $db_host = '127.0.0.1';
    if(empty($db_port)) $db_port = '3306';

    $config['development']['database']['username'] = $db_user;
    $config['development']['database']['password'] = $db_password;
    $config['development']['database']['host'] = $db_host;
    $config['development']['database']['port']= $db_port;
    $config['development']['database']['dbname'] = $db_name;

    $config['development']['rest']['client']['api_key'] = $pressmind_api_key;
    $config['development']['rest']['client']['api_user'] = $pressmind_api_user;
    $config['development']['rest']['client']['api_password'] = $pressmind_api_password;

    //Setting some default values in config

    $config['development']['server']['document_root'] = 'BASE_PATH';
    $config['development']['docs_dir'] = 'APPLICATION_PATH/docs';

    // Setup REST server
    $config['development']['rest']['server']['api_endpoint'] = '/wp-content/themes/travelshop/rest';

    // Setup the Preview URL
    $config['development']['data']['preview_url'] = "/examples/detail.php?id={{id_media_object}}&preview={{preview}}";

    // Setup some Pathes, all relative to to pressmind lib
    $config['development']['view_scripts']['base_path'] = "APPLICATION_PATH/template-parts/pm-views";
    $config['development']['file_handling']['storage']['bucket'] = "WEBSERVER_DOCUMENT_ROOT/wp-content/uploads/pressmind/downloads";
    $config['development']['file_handling']['http_src'] = "WEBSERVER_HTTP/wp-content/uploads/pressmind/downloads";

    // Setup Scaffolder Templates
    $config['development']['scaffolder_templates']['overwrite_existing_templates'] = false;
    $config['development']['scaffolder_templates']['base_path'] = "APPLICATION_PATH/template-parts/pm-views/scaffolder";

    // Image Processor
    $config['development']['image_handling']['storage']['bucket'] = "WEBSERVER_DOCUMENT_ROOT/wp-content/uploads/pressmind/images";
    $config['development']['image_handling']['http_src'] = "WEBSERVER_HTTP/wp-content/uploads/pressmind/images";

    // Enable WebPicture Support
    $config['development']['image_handling']['processor']['webp_support'] = true;

    // Setup Image Derivatives
    $config['development']['image_handling']['processor']['derivatives']['teaser'] = [];
    $config['development']['image_handling']['processor']['derivatives']['teaser']['max_width'] = 250;
    $config['development']['image_handling']['processor']['derivatives']['teaser']['max_height'] = 170;
    $config['development']['image_handling']['processor']['derivatives']['teaser']['preserve_aspect_ratio'] = true;
    $config['development']['image_handling']['processor']['derivatives']['teaser']['crop'] = true;
    $config['development']['image_handling']['processor']['derivatives']['teaser']['horizontal_crop'] = "center";
    $config['development']['image_handling']['processor']['derivatives']['teaser']['vertical_crop'] = "center";
    $config['development']['image_handling']['processor']['derivatives']['teaser']['webp_create'] = true;
    $config['development']['image_handling']['processor']['derivatives']['teaser']['webp_quality'] = 80;

    $config['development']['image_handling']['processor']['derivatives']['detail_thumb'] = [];
    $config['development']['image_handling']['processor']['derivatives']['detail_thumb']['max_width'] = 180;
    $config['development']['image_handling']['processor']['derivatives']['detail_thumb']['max_height'] = 180;
    $config['development']['image_handling']['processor']['derivatives']['detail_thumb']['preserve_aspect_ratio'] = true;
    $config['development']['image_handling']['processor']['derivatives']['detail_thumb']['crop'] = true;
    $config['development']['image_handling']['processor']['derivatives']['detail_thumb']['horizontal_crop'] = "center";
    $config['development']['image_handling']['processor']['derivatives']['detail_thumb']['vertical_crop'] = "center";
    $config['development']['image_handling']['processor']['derivatives']['detail_thumb']['webp_create'] = true;
    $config['development']['image_handling']['processor']['derivatives']['detail_thumb']['webp_quality'] = 80;

    $config['development']['image_handling']['processor']['derivatives']['detail'] = [];
    $config['development']['image_handling']['processor']['derivatives']['detail']['max_width'] = 610;
    $config['development']['image_handling']['processor']['derivatives']['detail']['max_height'] = 385;
    $config['development']['image_handling']['processor']['derivatives']['detail']['preserve_aspect_ratio'] = true;
    $config['development']['image_handling']['processor']['derivatives']['detail']['crop'] = true;
    $config['development']['image_handling']['processor']['derivatives']['detail']['horizontal_crop'] = "center";
    $config['development']['image_handling']['processor']['derivatives']['detail']['vertical_crop'] = "center";
    $config['development']['image_handling']['processor']['derivatives']['detail']['webp_create'] = true;
    $config['development']['image_handling']['processor']['derivatives']['detail']['webp_quality'] = 80;

    $config_file = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'pm-config.php';
    $config_text = "<?php\n\$config = " . _var_export($config, true) . ';';
    echo 'Writing config to ' . $config_file . "\n";
    file_put_contents($config_file, $config_text);
}

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

$args = $argv;
$args[1] = isset($argv[1]) ? $argv[1] : null;

$namespace = 'Pressmind\ORM\Object';

if($args[1] != 'only_static') {
    $config = Registry::getInstance()->get('config');

    if($first_install) {
        $first_install_success = true;
        Writer::write('Creating required directories', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
        $required_directories = [];
        $required_directories[] = HelperFunctions::buildPathString([APPLICATION_PATH, 'Custom', 'MediaType']);
        $required_directories[] = HelperFunctions::replaceConstantsFromConfig($config['logging']['log_file_path']);
        $required_directories[] = HelperFunctions::replaceConstantsFromConfig($config['tmp_dir']);
        if ($config['file_handling']['storage']['provider'] == 'filesystem') {
            $required_directories[] = HelperFunctions::replaceConstantsFromConfig($config['file_handling']['storage']['bucket']);
        }
        if ($config['image_handling']['storage']['provider'] == 'filesystem') {
            $required_directories[] = HelperFunctions::replaceConstantsFromConfig($config['image_handling']['storage']['bucket']);
        }
        $required_directories[] = HelperFunctions::buildPathString([HelperFunctions::replaceConstantsFromConfig($config['docs_dir']), 'objecttypes']);

        foreach ($required_directories as $directory) {
            if (!is_dir($directory)) {
                if(mkdir($directory, 0775, true)) {
                    Writer::write('Directory ' . $directory . ' created', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
                } else {
                    Writer::write('Failed to create directory ' . $directory, Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
                    $first_install_success = false;
                }
            }
        }
        if(!$first_install_success) {
            Writer::write('Creating required directories failed! Installation aborted!', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
            die();
        }
    }

    foreach (Info::STATIC_MODELS as $model) {
        try {
            $model_name = $namespace . $model;
            Writer::write('Creating database table for model: ' . $model_name, Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
            $scaffolder = new DB\Scaffolder\Mysql(new $model_name());
            $scaffolder->run($args[1] === 'drop_tables');
            foreach ($scaffolder->getLog() as $scaffolder_log) {
                Writer::write($scaffolder_log, Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
            }
        } catch (Exception $e) {
            Writer::write($model_name, Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_ERROR);
            Writer::write($e->getMessage(), Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_ERROR);
        }
    }

    try {
        Writer::write('Installing scheduler tasks', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
        $existing_scheduled_tasks = Task::listAll();
        foreach ($existing_scheduled_tasks as $existing_scheduled_task) {
            Writer::write('Deleting existing task "' . $existing_scheduled_task->name . '"', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
            $existing_scheduled_task->delete(true);
        }
        foreach ($config['scheduled_tasks'] as $config_scheduled_task) {
            $scheduled_task = new Task();
            $scheduled_task->name = $config_scheduled_task['name'];
            $scheduled_task->description = isset($config_scheduled_task['description']) ? $config_scheduled_task['description'] : null;
            $scheduled_task->class_name = $config_scheduled_task['class_name'];
            $scheduled_task->schedule = json_encode($config_scheduled_task['schedule']);
            $scheduled_task->last_run = new \DateTime();
            $scheduled_task->active = true;
            $scheduled_task->running = false;
            $scheduled_task->error_count = 0;
            $scheduled_task->methods = [];
            foreach ($config_scheduled_task['methods'] as $config_scheduled_task_method) {
                $task_method = new Task\Method();
                $task_method->name = $config_scheduled_task_method['method'];
                $task_method->parameters = json_encode($config_scheduled_task_method['parameters']);
                $task_method->position = intval($config_scheduled_task_method['position']);
                $scheduled_task->methods[] = $task_method;
            }
            $scheduled_task->create();
            Writer::write('New task "' . $scheduled_task->name . '" created', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
        }
    } catch (Exception $e) {
        Writer::write($e->getMessage(), Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_ERROR);
    }

    try {
        Writer::write('Requesting and parsing information on media object types ...', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
        $importer = new Import();
        $ids = [];
        $client = new Client();
        $response = $client->sendRequest('ObjectType', 'getAll');
        $media_types = [];
        $media_types_pretty_url = [];
        $media_types_allowed_visibilities = [];
        foreach ($response->result as $item) {
            Writer::write('Parsing media object type ' . $item->type_name, Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
            $media_types[$item->id_type] = ucfirst(HelperFunctions::human_to_machine($item->type_name));
            $ids[] = $item->id_type;
            $pretty_url = [
                'prefix' => '/' . HelperFunctions::human_to_machine($item->type_name) . '/',
                'field' => ['name' => 'name'],
                'strategy' => 'none',
                'suffix' => '/'
            ];
            $media_types_pretty_url[$item->id_type] = $pretty_url;
            $media_types_allowed_visibilities[$item->id_type] = [30];
        }
        $config['data']['media_types'] = $media_types;
        $config['data']['media_types_pretty_url'] = $media_types_pretty_url;
        $config['data']['media_types_allowed_visibilities'] = $media_types_allowed_visibilities;
        Registry::getInstance()->get('config_adapter')->write($config);
        Registry::getInstance()->add('config', $config);
        $importer->importMediaObjectTypes($ids);
    } catch (Exception $e) {
        Writer::write($e->getMessage(), Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_ERROR);
    }
}
echo "\n";
Writer::write('It is recommended to install a cronjob on your system. Add the following line to your servers crontab:', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
Writer::write('*/1 * * * * php ' . APPLICATION_PATH . '/cli/cron.php > /dev/null 2>&1', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
echo "\n";
if($args[1] == 'with_static' || $args[1] == 'only_static') {
    try {
        Writer::write('Dumping static data, this may take a while ...', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
        Writer::write('Data will be dumped using "gunzip" and "mysql" with "shell_exec". Dump data in ' . HelperFunctions::buildPathString([dirname(__DIR__), 'src', 'data']) . ' by hand if shell_exec fails', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
        $config = Registry::getInstance()->get('config');
        Writer::write('Dumping data for pmt2core_airlines', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
        shell_exec("gunzip < " . HelperFunctions::buildPathString([dirname(__DIR__), 'src', 'data', 'pmt2core_airlines.sql.gz']) . " | mysql --host=" . $config['database']['host'] . " --user=" . $config['database']['username'] . " --password=" . $config['database']['password'] . " " . $config['database']['dbname']);
        Writer::write('Dumping data for pmt2core_airports', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
        shell_exec("gunzip < " . HelperFunctions::buildPathString([dirname(__DIR__), 'src', 'data', 'pmt2core_airports.sql.gz']) . " | mysql --host=" . $config['database']['host'] . " --user=" . $config['database']['username'] . " --password=" . $config['database']['password'] . " " . $config['database']['dbname']);
        Writer::write('Dumping data for pmt2core_banks', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
        shell_exec("gunzip < " . HelperFunctions::buildPathString([dirname(__DIR__), 'src', 'data', 'pmt2core_banks.sql.gz']) . " | mysql --host=" . $config['database']['host'] . " --user=" . $config['database']['username'] . " --password=" . $config['database']['password'] . " " . $config['database']['dbname']);
        Writer::write('Dumping data for pmt2core_geozip', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
        shell_exec("gunzip < " . HelperFunctions::buildPathString([dirname(__DIR__), 'src', 'data', 'pmt2core_geozip.sql.gz']) . " | mysql --host=" . $config['database']['host'] . " --user=" . $config['database']['username'] . " --password=" . $config['database']['password'] . " " . $config['database']['dbname']);
    } catch (Exception $e) {
        Writer::write($e->getMessage(), Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_ERROR);
    }
} else {
    echo "\n";
    Writer::write('Some optional static data has not been dumped yet. If this data is needed (you will know, if) dump static data by calling "install.php with_static" or "install.php only_static"', Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
    Writer::write('You can also dump the data by hand. Data resides here: ' . HelperFunctions::buildPathString([dirname(__DIR__), 'src', 'data']), Writer::OUTPUT_SCREEN, 'install', Writer::TYPE_INFO);
}


/**
 * @param $expression
 * @param bool $return
 * @return mixed|string|string[]|null
 */
function _var_export($expression, $return = false) {
    $export = var_export($expression, true);
    $export = preg_replace("/^([ ]*)(.*)/m", '$1$1$2', $export);
    $array = preg_split("/\r\n|\n|\r/", $export);
    $array = preg_replace(["/\s*array\s\($/", "/\)(,)?$/", "/\s=>\s$/"], [NULL, ']$1', ' => ['], $array);
    $export = join(PHP_EOL, array_filter(["["] + $array));
    if ($return) {
        return $export;
    } else  {
        echo $export;
    }
    return null;
}
// echo '!!!ATTENTION: Please have a look at the CHANGES.md file, there might be important information on breaking changes!!!!' . "\n";
