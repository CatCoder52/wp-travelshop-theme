<?php
/**
 * This script sends a test e-mail to a defined address and print's the phpmailer (debug level 3) output.
 * It's based on the wp_mail() function to check the whole application configuration by sending this e-mail
 * see config-theme for the SMTP AUTH config, which is hooked in functions/email_smtp.php
 */

use Pressmind\Travelshop\ThemeActivation;

ini_set('display_errors', 'On');
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Init
if (php_sapi_name() !== 'cli') {
    die("Meant to be run from command line");
}

function find_wordpress_base_path()
{
    $dir = dirname(__FILE__);
    do {
        //it is possible to check for other files here
        if (file_exists($dir . "/wp-config.php")) {
            return $dir;
        }
    } while ($dir = realpath("$dir/.."));
    return null;
}

$wp_path = find_wordpress_base_path() . "/";

define('WP_USE_THEMES', false);

require_once($wp_path . 'wp-load.php');

global $wp, $wp_query, $wp_the_query, $wp_rewrite, $wp_did_header;

add_action( 'wp_mail_failed', function ( $error ) {
    echo $error->get_error_message();
} );

if (TS_SMTP_ACTIVE === true) {
    add_action('phpmailer_init', function ($phpmailer) {
        $phpmailer->SMTPDebug = 3;
    });
}

$email_to = readline('Send email to <name@email.de>:');
if(filter_var($email_to, FILTER_VALIDATE_EMAIL) === false){
    echo "email is not well formatted or not correct, aborting\n";
    exit;
}

if(wp_mail($email_to, 'Test E-Mail '.site_url(), "Test E-Mail from Travelshop") === true){
    echo "email is send, check your inbox\n";
}
