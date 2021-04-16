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
                        if($c == 2) {
                            echo '<li class="bc-separator">';
                            echo '<a itemprop="item" href="' . $item->url . '">...</a>';
                            echo '</li>';
                        }
                        ?>
                        <li itemprop="itemListElement" itemscope
                            itemtype="https://schema.org/ListItem" class="breadcrumb-item">
                            <?php if (empty($item->url) === false){ ?><a itemprop="item"
                                                                         href="<?php echo $item->url; ?>"><?php } ?>
                                <span itemprop="name"><?php echo ($c == 1 ? '
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <polyline points="5 12 3 12 12 3 21 12 19 12" />
                                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                </svg>' : $item->name); ?></span>
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