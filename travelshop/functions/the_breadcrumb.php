<?php

/**
 * @param string $sep
 * @param string $home_title
 * @param object[] $custom_path object{name, url}
 */
function the_breadcrumb($sep = ' › ', $home_title = 'Startseite', $custom_path = array())
{
    global $post;

    if (is_category() || is_archive() || $post == null) {
         return;
    }


    if(empty($custom_path) === true){
    $path = array();

    // Add Home
    $item = new stdClass();
    $item->name = $home_title;
    $item->url = site_url();
    $path[] = $item;


    // Add Parent Pages
    $ancestors = get_post_ancestors($post);

    $posts = array();
    if (empty($post) === false && $post->post_parent) {
        $posts = get_posts(array('include' => $ancestors, 'order_by' => 'parent', 'post_type' => $post->post_type));
    }

    krsort($posts);

    foreach ($posts as $p) {
        $item = new stdClass();
        $item->name = $p->post_title;
        $item->url = get_permalink($p->ID);
        $path[] = $item;
    }


    // Add the current post

    $item = new stdClass();
    $item->name = $post->post_title;
    $item->url = null;
    $path[] = $item;

    }else{
        $path = $custom_path;
    }

    ?>
    <section class="breadcrumb-wrapper">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol itemscope itemtype="https://schema.org/BreadcrumbList" class="breadcrumb">
                    <?php

                    $c = 0;
                    foreach ($path as $item) {
                        $c++;
                        ?>
                        <li itemprop="itemListElement" itemscope
                            itemtype="https://schema.org/ListItem" class="breadcrumb-item">
                            <?php if (empty($item->url) === false){ ?><a itemprop="item"
                                                                         href="<?php echo $item->url; ?>"><?php } ?>
                                <span itemprop="name"><?php echo $item->name; ?></span>
                                <?php if (empty($item->url) === false){ ?></a><?php } ?>
                            <meta itemprop="position" content="<?php echo $c + 1; ?>"/>
                        </li>
                        <?php

                        if (!empty($sep) && $c < count($path)) {
                            echo $sep;
                        }
                    }
                    ?>
                </ol>
            </nav>
        </div>
    </section>
    <?php

}