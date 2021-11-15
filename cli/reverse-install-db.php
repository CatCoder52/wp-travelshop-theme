<?php
/**
 * This file is for theme developers, that are using the customer specific
 * pm-config.php for local debugging or developing purposes
 */
if (php_sapi_name() !== 'cli') {
    die("This file is meant to be run from command line");
}

echo "This script creates a database config based on the \n";

if (readline("Type yes to create the given mysql database and the database user from the pm-config.php: ") != 'yes') {
    exit("aborted");
}
$config_file = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'pm-config.php';
echo "config_file: " . $config_file . "\n";
if (!file_exists($config_file)) {
    exit("error: config file does not exist: $config_file");
}
/**
 * @var $config
 */
require $config_file;
echo "To create the database and the user, we need database admin-user that have \"CREATE DATABASE\" and \"CREATE USER\" privileges for this host: " . $config['development']['database']['host'] . " (given in pm-config.php)\n";
$options = getopt('', [
    'db-root-user::',
    'db-root-password::',
]);
// if no values are set by parameter, we ask...
$db_root_user = !empty($options['db-root-user']) ? $options['db-root-user'] : readline("Enter Database username: ");
$db_root_password = !empty($options['db-root-password']) ? $options['db-root-password'] : readline("Enter database user password: ");
echo "\n";
echo "\n";
echo "pm-config.php contains the following database configuration:\n";
echo "given db host: ".$config['development']['database']['host'] . "\n";
echo "given db dbname: ".$config['development']['database']['dbname'] . "\n";
echo "given db username: ".$config['development']['database']['username'] . "\n";
echo "given db password: ".$config['development']['database']['password'] . "\n";
echo "\n";
echo "\n";
if (!readline("Create this database with this credentials on the given host? Type yes: ") == 'yes') {
    exit("aborted");
}
$dbh = new Pdo("mysql:host=" . $config['development']['database']['host'], $db_root_user, $db_root_password);
$SQL = "CREATE DATABASE `" . $config['development']['database']['dbname'] . "`;
                CREATE USER '" . $config['development']['database']['username'] . "'@'localhost' IDENTIFIED BY '" . $config['development']['database']['password'] . "';
                GRANT ALL ON `" . $config['development']['database']['dbname'] . "`.* TO '" . $config['development']['database']['username'] . "'@'localhost';
                FLUSH PRIVILEGES;";
if ($dbh->exec($SQL) === false) {
    echo "Error:\n";
    echo implode("\n", $dbh->errorInfo()) . "\n";
    exit(1);
}
echo "database and user successfully created\n";
echo "next: run install.php to load pressmind content in this database\n";