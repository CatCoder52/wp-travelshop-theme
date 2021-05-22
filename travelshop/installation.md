# Installation
#### 1. Download
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

    
#### 2. Create a database 
It is recommended to create a dedicated database for the pressmind content
(do not use the wordpress default database).
```shell script
mysql -u root -p;
mysql> CREATE DATABASE pressmind;
mysql> GRANT ALL ON pressmind.* TO 'my_database_user'@'localhost' IDENTIFIED BY 'my_database_password' WITH GRANT OPTION;
```

#### 3. Run composer
Install theme dependencies.
```shell script
cd /var/www/htdocs/wp-content/themes/travelshop
composer install
```

#### 4. Setup pressmind SDK
Run the pressmind SDK installer. 
The script will ask for some database as well as pressmind API credentials and then 
it will configure the sdk with custom models.

```shell script
cd /var/www/htdocs/wp-content/themes/travelshop/cli/
php install.php
```

The install script creates a config file; edit if you need it.
If you have a big system, it is recommended to check these properties.

```shell script
nano /var/www/htdocs/wp-content/themes/travelshop/cli/pm-config.php
```

To check a valid installation, read the command line output.
You can also have a look in your database; there you will find some tables.

#### 5. Import the data
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

#### 6. Theme activation
Activate the theme.
(Please remove the wordpress default themes like twenty*.)


#### 7. Check config files
Check these files for advanced configuration:
* config-theme.php
* config-routing.php
* pm-config.php (pressmind SDK config)

Also check functions.php: the first few lines contain onboarding code that can be removed.


#### 8. Ready!
After the full import is done, you can build your site.

#### pressmind PIM integration
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

## Maintenance & troubleshooting

If something has changed on the pressmind model run:
````shell script
php install.php
php import.php fullimport
````

If you think that something on the data model is buggy, try:
````shell script
php integrity_check.php
````

If it is still buggy:
````shell script
mysql -u root -p;
mysql> DROP database pressmind;
mysql> CREATE database pressmind;
php install.php
php import.php fullimport
````

For pressmind sdk updates run (do not try this in production):
```shell script
composer update
php install.php
php import.php fullimport
```
Have a look at https://github.com/pressmind/sdk to check the last changes.

#### Routing
The theme contains a route processor, based on WordPress `parse_request` hook. 
See src/RouteProcessor.php how it works.

Each route has 3 properties:
1. The Route-(Regex)
2. A Hook (will trigger on match, can inject metadata but also matches product uri against the database.)
3. A template

So it is possible to route a URL to a custom page with native WordPress 
support like get_header() & get_footer() - stuff`
but without the post type logic like `the_post`

#### What can I do with this routing?
Build awesome sites! By default, you need two routes:

1. The route to the product detail page
2. A route to the search

In reality, a travelshop has different product types like 
day trips, round trips, "hotel only" and so on. 
For each of these product types you can build with custom templates a custom route.

Default routes:
```
// your default search route (loads template: pm-search.php)
https://www.yoursites/search/

// default product page (loads template: pm-detail.php)
https://www.yoursites/detail/{PRODUCT URI}

```

Example of a tour operator specific routing:
```
// hotel search route (loads template: pm-hotelsearch.php)
https://www.yoursites/hotels/

// hotel product page (loads template: pm-hotel.php)
https://www.yoursites/hotel/{PRODUCT_URI}

// trip search route (loads template: pm-trips.php)
https://www.yoursites/trips/

// trip product page (loads template: pm-trip.php)
https://www.yoursites/trip/{PRODUCT URI}

```

Configure your routes in wp-content/themes/travelshop/config-routing.php
```php
$routes = array(
    'pmwc_default_detail_route' => new Route('^detail/(.+?)', 'pmwc_detail_hook', 'pm-detail'),
    'pmwc_default_search_route' => new Route('^search/?', '', 'pm-search'),
);
```
#### Routing hook
If you configure your custom routing or want to modify meta tags for pressmind product pages, look at the `pmwc_detail_hook`
in `wp-content/themes/travelshop/config-routing.php`.

How this route hook is used:
1. The hook is fired before the WordPress page is loaded.
2. It modifies the wp request.
3. It loads product data by a seo friendly url.
4. It adds metadata like description, title, etc. in the WordPress header template.

Pro hint:
Use a custom route for 301-redirects if you have a lot of product urls to migrate during a relaunch. 

