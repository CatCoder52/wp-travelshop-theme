<?php
// remove users from sitemap
add_filter('wp_sitemaps_add_provider', function ($provider, $name) {
    if ('users' === $name) {
        return false;
    }
    return $provider;
}, 10, 2);

// remove tags an category pages from sitemap
add_filter('wp_sitemaps_taxonomies', function ($taxonomies) {
    unset($taxonomies['post_tag'],$taxonomies['category']);
    return $taxonomies;
}
);

// add pressmind primary media object types to the sitemap.xml
add_filter('init', function () {
    global $config;
    if (!empty($config['data']['primary_media_type_ids']) && is_array($config['data']['primary_media_type_ids'])) {
        foreach ($config['data']['primary_media_type_ids'] as $id_object_type) {
            // this name must match [a-z]
            $name = strtolower($config['data']['media_types'][$id_object_type]);
            $provider = new SitemapProvider($name, $id_object_type);
            wp_register_sitemap_provider($name, $provider);
        }
    }
}
);