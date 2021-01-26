# Installation with Composer
#### 1. WordPress Theme
 Install the WordPress Theme (extract wp-travelshop-theme.zip to your theme dir (wp-content/themes/travelshop))  .
 After extracting the zip file your themes folder should look something like this: 
* themes
    * travelshop
        * assets/
        * cli/
        * Custom/
        * functions/
        * src/
        * template-parts
        * ...

#### 2. Run Composer
run composer install in the plugin dir
```shell script
cd /var/www/htdocs/wp-content/themes/travelshop
composer install
```

#### 3. Create a database 
It's recommend to create a dedicated database for the pressmind content.
```shell script
mysql -u root -p;
mysql> CREATE DATABASE pressmind;
mysql> GRANT ALL ON pressmind.* TO 'my_database_user'@'localhost' IDENTIFIED BY 'my_database_password' WITH GRANT OPTION;
```

#### 4. Setup pressmind web-core SDK
Run the web-core installer. 
The script will ask for some database- and pressmind API credentials and then will install the customer specific data objects and configures the sdk with custom models.

```shell script
cd /var/www/htdocs/wp-content/themes/travelshop/cli/
php install.php
```

#### 5. Import the data
the import script will import the whole data from pressmind to your server.
the script inserts records in the database, will download images
and processes the images to the defined image derivatives (see pm-config.php)
all images are processed in the background 
(use `top` to see what is happens after or between the script is running) 

```shell script
php import.php fullimport
```
#### 6. Ready!
if the full import is done you can build your site.


#### pressmind PIM Integration
Please send the path to your WordPress site (stage and/or production) 
to your pressmind integration manager.
After our integration is done, the pressmind application will push data changes to your site.
Even the user can click on a preview-button or can trigger the database update manually.

The Pressmind uses this two endpoints:

```
// Case 1: Push data on change to your site
https://www.yoursite.de/wp-content/themes/travelshop/pm-import.php?type=import&id_media_object={ID}

// Case 2: Preview a Detailpages
https://www.yoursite.de/wp-content/themes/travelshop/pm-preview.php?id_media_object={ID}
```

## Maintenance & Troubleshooting

If something has changed on the pressmind model run:
````shell script
php install.php
php import.php fullimport
````

If you think something on the data-model is buggy, try
````shell script
php integrity_check.php
````

If it's still buggy
````shell script
mysql -u root -p;
mysql> DROP database pressmind;
mysql> CREATE database pressmind;
php install.php
php import.php fullimport
````

For pressmind sdk updates run (don't try this in production)
```shell script
composer update
php install.php
php import.php fullimport
```
Have a look at https://github.com/pressmind/sdk to check the last changes

#### Routing
the theme contains a route processor, based on WordPress `parse_request` hook. 
See src/RouteProcessor.php how it works.

Each route has 3 properties:
1. The Route-(Regex)
2. A Hook (will trigger on match, can inject metadata but also matches product uri against the database)
3. A template

So it's possible to route a URL to a custom page with native WordPress 
support like get_header() & get_footer() - stuff`
but without the post type logic like `the_post`

#### What can I do with this routing?
Build awesome sites! By default, you need two routes

1. The route to the product detail page
2. A route to the search

In real world cases a travelshop have different product types like 
day-trips, round-trips, hotel-only and so on. 
For each of these products type you can build a custom route, with custom templates 

Default routes:
```
// your default search route (loads template: pm-search.php)
https://www.yoursites/search/

// default product page (loads template: pm-detail.php)
https://www.yoursites/detail/{PRODUCT URI}

```

Example of a tour-operator specific routing:
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
#### Routing Hook
if you configure you're custom routing or want to modify meta tags for pressmind product pages, look at the `pmwc_detail_hook`
in `wp-content/themes/travelshop/config-routing.php` 

How is this route hook used:
1. The Hook is fired before the WordPress page is loaded
2. Modify the wp request
3. Load product data by a seo friendly url
4. Add metadata like description, title, etc. in the WordPress header template

Pro Tip:
Use a custom route for 301-redirects if you have to a lot product urls to migrate during a relaunch. 

