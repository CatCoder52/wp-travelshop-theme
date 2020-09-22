<?php

ini_set('error_reporting', -1);
ini_set('display_errors', 'On');

// Config
use Pressmind\Travelshop\AdminPage;
use Pressmind\Travelshop\PluginActivation;
use Pressmind\Travelshop\Shortcodes;
use Pressmind\Travelshop\WPFunctions;
use Pressmind\Travelshop\RouteProcessor;
use Pressmind\Travelshop\Router;
use Pressmind\Travelshop\Route;

// this code is only for a better onboarding, remove in production
    if(file_exists(get_template_directory().'/vendor/pressmind/lib/config.json') === false ){
        if(file_exists(get_template_directory().'/vendor/pressmind/lib/bootstrap.php') === false ) {
            echo 'Error: pressmind web-core SDK is not installed<br>';
            echo 'run "composer install" in ' . __DIR__;
        } else if(file_exists(get_template_directory().'/vendor/pressmind/lib/config.json') === false ) {
            echo 'Error: pressmind web-core SDK is not installed correctly<br>';
            echo 'config.json is missing';
        }
        exit();
    }

    // check if web-core sdk installation is done
    if(file_exists(get_template_directory().'/vendor/pressmind/lib/src/Custom/MediaType') === true
        && count(glob(get_template_directory().'/vendor/pressmind/lib/src/Custom/MediaType/*.php')) <= 1){
            echo 'Error: pressmind web-core SDK is not configured correctly.<br>';
            echo 'run "php install.php " in ' . get_template_directory().'/vendor/pressmind/lib/cli/';
            exit();
    }


// load the theme-config
require_once 'config-theme.php';

// pressmind web-core sdk
require_once 'vendor/pressmind/lib/bootstrap.php';

// admin/system related functions
require_once 'src/PluginActivation.php';
require_once 'src/AdminPage.php';
require_once 'src/Shortcodes.php';
require_once 'src/WPFunctions.php';
require_once 'src/BuildSearch.php';
require_once 'src/RouteProcessor.php';
require_once 'src/Route.php';
require_once 'src/Router.php';


// Cleanup
require_once 'functions/cleanup_meta_includes.php';
require_once 'functions/disable_emojis.php';

// Menus
require_once 'functions/menus.php';
require_once 'functions/the_breadcrumb.php';
require_once 'functions/theme_support.php';
require_once 'functions/image-sizes.php';

// Header
require_once 'functions/http_header.php';

class PMTravelShop{

    public $Shortcodes;
    public $AdminPage;
    public $PluginActivation;
    public $RouteProcessor;
    public $Redis = null;


    public function __construct($routes)
    {
        $this->RouteProcessor = RouteProcessor::init(new Router('pmwc_routes'), $routes, TS_TEMPLATE_DIR);
        $this->Shortcodes = new Shortcodes();
        $this->AdminPage = new AdminPage();
        $this->PluginActivation = new PluginActivation();
        if(defined(PM_REDIS_HOST) === true){
            $this->Redis = new Redis();
            $this->Redis->connect(PM_REDIS_HOST, PM_REDIS_PORT);
        }
    }

}

require_once 'config-routing.php';
$PMTravelShop = new PMTravelShop($routes);