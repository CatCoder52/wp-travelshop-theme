<?php
if ( !defined('ABSPATH') ) {
    @ini_set('include_path', '../../../');
    require_once('../../../wp-load.php');
}
?>
{
    "dir": "ltr",
    "lang": "de-DE",
    "name": "<?php echo get_bloginfo('name'); ?>",
    "short_name": "<?php echo get_bloginfo('name'); ?>",
    "description": "<?php echo get_bloginfo('description');?>",
    "icons": [
        {
            "src": "/wp-content/themes/travelshop/assets/img/icon_512.png",
            "type": "image/png",
            "sizes": "512x512",
            "purpose": "any maskable"
        },
        {
            "src": "/wp-content/themes/travelshop/assets/img/icon_192.png",
            "type": "image/png",
            "sizes": "192x192",
            "purpose": "any maskable"
        },
        {
            "src": "/wp-content/themes/travelshop/assets/img/icon_180.png",
            "type": "image/png",
            "sizes": "180x180",
            "purpose": "any maskable"
        },
        {
            "src": "/wp-content/themes/travelshop/assets/img/icon_48.png",
            "type": "image/png",
            "sizes": "48x48",
            "purpose": "any maskable"
        },
        {
            "src": "/wp-content/themes/travelshop/assets/img/icon_32.png",
            "type": "image/png",
            "sizes": "32x32",
            "purpose": "any maskable"
        },
        {
            "src": "/wp-content/themes/travelshop/assets/img/icon_16.png",
            "type": "image/png",
            "sizes": "16x16",
            "purpose": "any maskable"
        }
    ],
    "background_color": "white",
    "theme_color": "#f4f4f4",
    "start_url": "/?source=pwa",
    "scope": "/",
    "display": "standalone",
    "orientation": "portrait-primary"
}