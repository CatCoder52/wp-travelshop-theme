# Routing
The theme contains a route processor, based on WordPress `parse_request` hook.
See config-routing.php and src/RouteProcessor.php how it works.

Each route has 3 properties:
1. The Route-(Regex)
2. A Hook (will trigger on match, can inject metadata but also matches product uri against the database.)
3. A template

So it is possible to route a URL to a custom page with native WordPress
support like get_header() & get_footer() - stuff`
but without the post type logic like `the_post`

## What can I do with this routing?
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
## Routing hook
If you configure your custom routing or want to modify meta tags for pressmind product pages, look at the `pmwc_detail_hook`
in `wp-content/themes/travelshop/config-routing.php`.

How this route hook is used:
1. The hook is fired before the WordPress page is loaded.
2. It modifies the wp request.
3. It loads product data by a seo friendly url.
4. It adds metadata like description, title, etc. in the WordPress header template.

Pro hint:
Use a custom route for 301-redirects if you have a lot of product urls to migrate during a relaunch. 

