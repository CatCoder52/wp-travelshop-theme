# Installation

## Preparation
* check [system requirements](readme-system-requirements.md)
* install the latest WordPress Version on your server (start clean, without any plugins)
* get a coffee
* follow the instructions below

## 1. Download
Install the WordPress theme. 
Download the [latest theme build](https://github.com/pressmind/wp-travelshop-theme/releases/latest) 
or use the current [development master](https://github.com/pressmind/wp-travelshop-theme/archive/refs/heads/master.zip)
and extract it to your theme dir (wp-content/themes/travelshop).
After extracting the zip/tarball file, your themes folder should look like this: 
* wp-content
    * themes
        * travelshop
            * assets/
            * cli/
            * Custom/
            * functions/
            *  src/
            * template-parts
            * ...

    
## 2. Create a database 
It is recommended to create a dedicated database for the pressmind content
(do not use the wordpress default database).
```shell script
mysql -u root -p;
mysql> CREATE DATABASE pressmind;
mysql> GRANT ALL ON pressmind.* TO 'my_database_user'@'localhost' IDENTIFIED BY 'my_database_password' WITH GRANT OPTION;
```

## 3. Run composer
Install theme dependencies.
```shell script
cd /var/www/htdocs/wp-content/themes/travelshop
composer install
```

## 4. Setup pressmind SDK
__Run the pressmind SDK installer.__
The script will ask for some database as well as pressmind API credentials and then 
it will configure the sdk with custom models.

```shell script
cd /var/www/htdocs/wp-content/themes/travelshop/cli/
php install.php
```

To check a valid installation, read the command line output.
You can also have a look in your database; there you will find some new tables, named like

```
// check the installation
// the database must contain tables like this:
-
objectdata_*
pmt2core_agencies
pmt2core_agency_to_media_object
pmt2core_airlines
pmt2core_airports
pmt2core_banks
pmt2core_brands
[...]
-
```

__Edit pm-config.php__<br>
If the installation process is successfull completed,
we have to edit the configuration:
The `pm-congfig.php`-file is created during the installation process
and contains all pressmind specific configuration options (see [here](https://github.com/pressmind/web-core-skeleton-basic/blob/master/quickstart/config.md) for further details).
Edit the following values based on your brief:

```shell script
nano /var/www/htdocs/wp-content/themes/travelshop/cli/pm-config.php
```

```php
// travelshop/pm-config.php
// setup the "@TODO" marked values from your brief
...
       'data' => [
            'touristic' => [...],
            'media_type_custom_import_hooks' => [...],
            'primary_media_type_ids' => [1234], // @TODO setup the primary media object type ids that are matching to your briefing
            'media_type_custom_import_hooks' => [...],
            'media_types' => [ // @TODO delete all items, that are not matching to your briefing
                1234 => 'Rundreisen', 
                5432 => 'Hotels',
            ],
...
```


## 5. Import the data
The import script will import the whole data from pressmind to your server.
The script inserts records in the database, downloads images
and processes the images to the defined image derivatives (see pm-config.php).
All images are processed in the background.
(Use `top` to see what happens while the script is running.) 
This process can take a while.

```shell script
cd /var/www/htdocs/wp-content/themes/travelshop/cli/
php import.php fullimport
```

If you need only a few products (for testing), use this command instead of the fullimport:
```shell script
php import.php mediaobject 12345,12346
```

In order to check a valid import, have a look into the database; some of the tables named with "objectdata_*" 
must contain data.

## 6. Theme activation
Activate the theme.
(Please remove the wordpress default themes like twenty*.)


## 7. Setup theme config

__config-theme.php__<br>This file contains theme specific constants. Edit the following values based on your brief:

```php
// travelshop/config-theme.php
// setup the "@TODO" marked values from your brief
...
define('TS_TOUR_PRODUCTS', 2277); // @TODO setup the primary object type here
...
define('TS_SEARCH', [ // @TODO setup the categorytree search items for the searchbar
    [ 'id_tree' => 4128, 'fieldname' => 'zielgebiet_default', 'name' => 'Zielgebiet', 'condition_type' => 'c'],
    [ 'id_tree' => 4127, 'fieldname' => 'reisethema_reisemerkmal_default', 'name' => 'Reisethema', 'condition_type' => 'c'],
]);
...
define('TS_FILTERS', [ // @TODO setup the categorytree search items for the advanced filter
    [ 'id_tree' => 4128, 'fieldname' => 'zielgebiet_default', 'name' => 'Zielgebiet', 'condition_type' => 'cl'],
    [ 'id_tree' => 4127, 'fieldname' => 'reisethema_reisemerkmal_default', 'name' => 'Reisethema', 'condition_type' => 'c'],
    [ 'id_tree' => 4141, 'fieldname' => 'reisearten_default', 'name' => 'Anreise', 'condition_type' => 'c'],
    // Example of a category tree from a sub object
    [ 'id_tree' => 4129, 'fieldname' => 'eigenschaften_default', 'name' => 'Unterkunftseigenschaften ', 'condition_type' => 'cl'],
    [ 'id_tree' => 4130, 'fieldname' => 'unterkunfts_kategorie', 'name' => 'Unterkunftskategorie', 'condition_type' => 'cl'],
]);
...
```

<br>
Check also this files for advanced configuration: 

__functions.php__<br>
Also check functions.php: the first few lines contain onboarding code that can be removed.

## 8. Ready!
After the full import is done, you can build your site.

# pressmind PIM integration
Please send the path to your WordPress site (stage and/or production) 
to your pressmind integration manager.
After our integration is done, the pressmind application will push data changes to your site.
Even the user can click on a preview button or can trigger the database update manually.

The pressmind application uses these two endpoints:

```
// Case 1: Push data on change to your site
https://www.yoursite.de/wp-content/themes/travelshop/pm-import.php?type=import&id_media_object={ID}

// Case 2: Preview a detail page
https://www.yoursite.de/wp-content/themes/travelshop/pm-preview.php?id_media_object={ID}
```

# Related links
* [Maintenance & troubleshooting](readme-maintenance.md)
* [Routing](readme-routing.md)
