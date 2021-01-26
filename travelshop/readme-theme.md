# Travelshop Theme

## The whole Concept
This theme is an example theme for building a enterprise ready travelshop.
It's just a basic boilerplate for creating awesome travelshop's based 
on the pressmind® PIM-System. 

#### Booking Engine 
The theme has no booking engine included. There are two ways to include a booking Engine

1. Bring/Integrate your own Booking Engine
2. Use the pressmind® IB3 Booking Engine to connect to many customer reservation systems 
(mostly based on the german market, like Kuschick, Bewotec, Blank, turista)
3. if you need a simple booking solution take also a look on the pressmind IB3 Engine, it can also handle 
bookings without a connected crs system in your backoffice


#### The Template Concept

Speed fst:
1. All WordPress related overload is removed:
(disabled functions: rest_output_link_wp_head, wp_oembed_add_discovery_links, 
rest_output_link_header, rsd_link,wlwmanifest_link, wp_shortlink_wp_head,wp_generator, emojis some more)

2. SASS Style, splitted in granular components to build critical path css on a smart way

3. Bootstrap

4. Less JS Frameworks, more pure JS.

5. All JS is loaded in the footer

6. WEBP Support

7. Theme for Pro's. Less WordPress Admin Pages, all settings are configured in config files.

#### High Availibilty (HA)
It's possible to use this theme for high traffic and availibility setups (e.g. AWS, Google, Kubernetes). 
ask you're pressmind team for further informations. 
in advance: don't use plugin's. ask us.
 
#### Caching
the theme is ready for redis object caching (based on PECL phpredis). It's also possible to use
the pressmind `advanced_cache.php` dropin. ask pressmind.
Don't use a other page cache (they don't know and can not handle pressmind product pages)

#### Amazon S3 
It's possible to store all assets (WordPress Media Library and the pressmind product images on Amazon S3 Storage).
Use the `pressmind S3 Stateless` Plugin for this case.
Don't use a other S3 plugins (they don't know and can not handle pressmind product pages)



## The Template files
* pm-config.php (the pressmind web-core sdk config, look he're for database credentials, pressmind api settings or image sizes)
* assets
    * /img (example pictures, don't use in production)
        * img.jpg 
        * logo.svg 
        * slide.jpg|webp
    * /js
        * ajax.js (ajax related functions, used for searching and filtering)
        * autocomplete.min.js (thirdparty framework, used for the autocomplete feature in the searchbar)
        * bootstrap.min.js (thirdparty framework)
        * daterangepicker.js (thirdparty framework, user for date range selection in filter or searchbar)
        * ion.rangeSlider.min.js (thirdparty framework, used for price and duration slider in filter or searchbar)
        * jquery-3.5.1.min.js (thirdparty framework)
        * moment.min.jsv (thirdparty framework, date formats)
        * popper-1.14.7.min.js (thirdparty framework, tooltips)
        * search.js (search related stuff, logic for searchfields)
        * ui.js (ui related stuff, like nice animations and so on)
    * /scss (the style)
        * /abstracts
        * /base
        * /components
        * /layout
        * /pages
        * /themes
        * /utils
        * /vendors
        * app.critical.scss
           * app.critical.css (the critical path css, loaded inline in the header)
        * app.scss
            * app.css (the whole css file)
* /cli
    * regenerate-images.php (run, to regenerate WordPress Image Derivates, if you haved changed them)
    * ...
    * import.php (importer for pressmind data)
    * install.php (installs the pressmind data model)
    * integrity_check.php (check/sync the datamodell with the pressmind® PIM)
    
* /functions
    * cleanup_meta_includes.php (remove unnessary stuff from WordPress)
    * disable_emojis.php (remove unnessary emojis)
    * http_header.php (configures the http header)
    * image-sizes.php (defines the WordPress images sizes)
    * menus.php (menu related stuff)
    * the_breadcrumb.php (a nice breadcrumb function, with pressmind category tree support)
    * theme_support.php (enables some theme features)
    
* /src
    * AdminPage.php (themes admin page)
    * BuildSearch.php (abstracts get parameter for the complex pressmind, see section GET-Requests/Deeplinks)
    * PluginActivation.php 
    * Route.php (Part of Routing)
    * RouteProcessor.php (Part of Routing)
    * Router.php (Part of Routing)
    * Shortcodes.php (enables the shortcode feature for pressmind search query)
    * WPFunctions.php
    
* /template-parts
    * /content (post-type specific templates)
        * content.php
        * content-page.php
        * content-post.php
        * content-single.php
    * /layout-blocks
        * 404.php
        * icon-teaser.php
        * image-teaser.php
        * info-teaser.php
        * jumbotron.php
        * product-teaser.php
        * search-header.php
    * /pm-search (search & filter related templates)
        * /filter 
            * category-tree.php
            * order.php
            * price-range.php
        * /search
            * category-tree-dropdown.php
            * date-picker.php
            * string-search.php
        * filter-vertical.php
        * result.php
        * result-pagination.php
        * search-bar.php
    * /pm-views (pressmind views, you need a view for each pressmind media_object type)
        *   Reise_Detail1.php (Media Object Type "Reise" Detailview)
        *   Reise_Teaser1.php (Media Object Type "Reise" view as Teaser, in use on the startpage or as searchresult)
        *   *_Example.php (during installation pressmind web-core sdk is creating some fullblown examples, named by *_Example.php)
    * /wp-views (wordpress views)
        *   image-teaser-view.php 
        *   info-teaser-view.php
* /vendor (home of the pressmind web-core sdk)
    * ...
    * /pressmind
                
* 404.php
* composer.json
* config-routing.php (setup your a custom routing here)
* config-theme.php (some theme related settings, don't put the constant to the wp-config.php, this is file is also used for a WordPressless Bootstrap in some file, like the pm-ajax-endpoint.php)
* footer.php
* functions.php (the main theme bootstrap)
* header.php 
* index.php (startpage)
* install.php (called from composer.json on post install. you can delete it in production enviroment)
* pm-ajax-endpoint.php (the ajax endpoint is for pressmind data only, currently it's mostly in use for the ajax base product search)
* pm-detail.php (the product page, the url/base route is configured in config-routing.php, you can setup a special page for each pressmind media object type)
* pm-preview.php (this url is called from pressmind PIM, it's just a redirect to preview the detailpage - don't edit this file)
* pm-search.php (the search site, the url is configured in config-routing.php)
* readme.md
* readme-theme.md
* singular.php
* style.css (theme description, not more, will not loaded)

## Icons
Icons are currently used from https://tablericons.com/ (SVG only - no icon fonts)
                
        
        
     
        








