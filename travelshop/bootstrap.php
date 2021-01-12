<?php
namespace Pressmind;

use Autoloader;
use Exception;
use Pressmind\DB\Adapter\Pdo;

/**
 * The pressmind lib needs five CONSTANTS to work
 * BASE_PATH: The base path of the application (usually the directory that contains the document_root folder)
 * APPLICATION_PATH: This is the path where all application files are stored (it's a good idea to have the base path outside the document_root of your webserver)
 * WEBSERVER_DOCUMENT_ROOT: the document_root of your webserver (should normally be be BASE_PATH . '/httpdocs)
 * WEBSERVER_HTTP: How the webpage is accessed via http(s) (https://your-domain.com)
 * ENV: The environment (development, testing, production)
 */
define('BASE_PATH', dirname(dirname(dirname(__DIR__))));
define('APPLICATION_PATH', __DIR__);
define('WEBSERVER_DOCUMENT_ROOT', BASE_PATH);
if (php_sapi_name() != "cli") {
    define('WEBSERVER_HTTP', ((empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off') ? 'http://' : 'https://') . $_SERVER['HTTP_HOST']);

    /**
     * WebP Support, if support of older Browsers like IE10 is required you can turn off WebP support here by using a conditional state based on request headers fo example
     */
    if (empty($_SERVER['HTTP_ACCEPT']) === false) {
        define('WEBP_SUPPORT', in_array('image/webp', explode(',', $_SERVER['HTTP_ACCEPT'])));
    }
} else {
    define('WEBSERVER_HTTP', 'http://127.0.0.1/');
}

/**
 * The ENV constant is used by the configuration to determine the environmet the application is running in
 * (so you can share the most common configurations from development to production or testing but overwrite the database credentials for example)
 * possible values are:
 * development
 * testing
 * production
 * For example purposes we set the ENV to development here, for real world applications it's a good idea to set an environment variable in a .htaccess file or in the webservers configuration
 */
define('ENV', 'development');
//define('ENV', getenv('APP_ENV');

/**
 * Import the Custom Autoloader
 */
require_once APPLICATION_PATH . DIRECTORY_SEPARATOR . 'Custom' . DIRECTORY_SEPARATOR . 'Autoloader.php';
\Custom\Autoloader::register();

/**
 * Import the composer autoloader
 */
require_once APPLICATION_PATH . '/vendor/autoload.php';


/**
 * Loading the configuration
 * Here we will use the PHP config-adapter to load and parse a configuration file
 * you can also use JSON Files for configuration.
 * It is required that in every configuration the keys development, testing and production do exist.
 * @See the generated config.php file (which is created during the install process) for the required structure and options
 * @See the different config adapters for further information on YAML, XML and INI files (Pressmind\Config\Adapter)
 */
$config_adapter = new Config('php', HelperFunctions::buildPathString([APPLICATION_PATH, 'config.php']), ENV);
$config = $config_adapter->read();

/**
 * Configure the database adapter
 */
$db_config = DB\Config\Pdo::create(
    $config['database']['host'],
    $config['database']['dbname'],
    $config['database']['username'],
    $config['database']['password']
);

/**
 * create the database adapter
 */
try {
    $db = new Pdo($db_config);
    if(strtolower($config['database']['engine']) == 'mysql') {
        $db->execute('SET SESSION sql_mode = "NO_ENGINE_SUBSTITUTION"');
    }
} catch (Exception $e) {

    if (
        empty($config['database']['host']) || empty($config['database']['dbname']) ||
        empty($config['database']['username']) || empty($config['database']['password'])
    ) {
        echo 'Error: database is not configured yet, please check ' . __DIR__ . '/config.json';
    }

    echo 'Error: ';
    echo $e->getMessage();
    exit;
}

/**
 * Init the registry and add configuration and database adapter
 * It's important that a registry is set and that it has the elements 'config' and 'db' set at least, otherwise the library won't work at all
 * For sure you are encouraged to add other elements to the registry if needed
 */
$registry = Registry::getInstance();
$registry->add('config', $config);
$registry->add('config_adapter', $config_adapter);
$registry->add('db', $db);
