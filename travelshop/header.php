<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,width=device-width,user-scalable=0">
    <link rel="preload" as="image" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/travelshop-logo.svg">
    <link rel="preload" as="image" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/slide-1.webp">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/scss/app.min.css?<?php echo filemtime(get_stylesheet_directory() . '/assets/scss/app.min.css'); ?>">
    <style>
        <?php
            /*
             * for optimizing the critical path rendering, try this instead the css include above
             * echo file_get_contents(get_stylesheet_directory().'/assets/scss/app.critical.min.css')."\r\n";
             */

            // load the wordpress default block library
            echo file_get_contents(realpath(__DIR__.'/../../../wp-includes/css/dist/block-library/style.min.css'));
            ?>
    </style>
    <?php wp_head(); ?>
</head>
<body>
<header class="header-main">
    <div class="container">
        <div class="row header-main-row">
            <div class="col-auto align-self-center d-block d-lg-none">
                <button class="toggler navbar-toggler offcanvas-toggler" type="button" data-target="#navbar"
                        aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#607D8B" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z"/>
                        <line x1="4" y1="6" x2="20" y2="6" />
                        <line x1="4" y1="12" x2="20" y2="12" />
                        <line x1="4" y1="18" x2="20" y2="18" />
                    </svg>
                </button>
            </div>
            <div class="col-auto align-self-center ">
                <a class="navbar-brand" href="<?php echo site_url(); ?>">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/travelshop-logo.svg" height="24"
                         class="d-inline-block align-middle" alt="">
                </a>
            </div>
            <div class="col align-self-center ">

                <?php
                if (has_nav_menu('primary') === true) {
                    ?>
                    <nav class="navbar navbar-expand-lg offcanvas" id="navbar">
                        <button class="offcanvas-close">
                            <i class="la la-times"></i> Menü schliessen
                        </button>
                        <div class="navbar-offcanvas">
                            <ul class="navbar-nav mr-auto ml-auto">

                                <?php
                                $menu_items = wpse_nav_menu_2_tree('primary');

                                foreach ($menu_items as $item) {

                                    // Top Level
                                    if (empty($item->wpse_children) === true) { // Level 1
                                        ?>
                                        <li class="nav-item active">
                                            <a class="nav-link"
                                               href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a>
                                        </li>
                                        <?php
                                    } else { // Level 2
                                        ?>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                                               role="button"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <?php echo $item->title; ?> <i class="la la-angle-down"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <?php
                                                foreach ($item->wpse_children as $child_items) {
                                                    ?>
                                                    <a class="dropdown-item"
                                                       href="<?php echo $child_items->url ?>"><?php echo $child_items->title; ?></a>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </nav>
                <?php } else { ?>
                    <nav class="navbar navbar-expand-lg offcanvas" id="navbar">
                        <small style="padding: 1rem; display: inline-block;">menu: ‚Desktop Horizontal Menu‘ not configured</small>
                    </nav>
                <?php } ?>
            </div>
            <div class="col-auto align-self-center  d-none d-lg-block col-search" id="search">
                <form class="input-group my-2 my-lg-0">
                    <input class="form-control" type="search" data-autocomplete="true" placeholder="Suchbegriff..."
                           aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-link">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#607D8B" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z"/>
                                <circle cx="10" cy="10" r="7" />
                                <line x1="21" y1="21" x2="15" y2="15" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-auto align-self-center  dropdown">
                <button class="toggler wishlist-toggler" type="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-heart" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#607D8B" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z"/>
                        <path d="M12 20l-7 -7a4 4 0 0 1 6.5 -6a.9 .9 0 0 0 1 0a4 4 0 0 1 6.5 6l-7 7" />
                    </svg>
                    <span class="count">3</span>
                </button>

                <div class="dropdown-menu dropdown-menu-right dropdown-menu-wishlist">
                    <div class="wishlist-items">
                        <div class="wishlist-item">
                            <span class="name"><a href="#">Reise #1</a></span>
                            <button class="wishlist-delete" type="button">
                                <i class="la la-times"></i>
                            </button>
                        </div>
                        <div class="wishlist-item">
                            <span class="name"><a href="#">Reise #1</a></span>
                            <button class="wishlist-delete" type="button">
                                <i class="la la-times"></i>
                            </button>
                        </div>
                        <div class="wishlist-item">
                            <span class="name"><a href="#">Reise #1</a></span>
                            <button class="wishlist-delete" type="button">
                                <i class="la la-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="wishlist-actions">
                        <a href='#' class="btn btn-outline-primary btn-block">
                            Zur Merkliste
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-auto align-self-center  d-block d-lg-none">
                <button class="toggler search-toggler" type="button" data-target="#search" aria-controls="search"
                        aria-expanded="false" aria-label="Toggle Search">
                    <i class="la la-search"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="modal fade" id="offanvas-backdrop">
        <div class="modal-dialog modal-xl" style="opacity: 0;">
            <div class="modal-content"></div>
        </div>
    </div>
    <div class="modal fade" id="search-backdrop">
        <div class="modal-dialog modal-xl" style="opacity: 0;">
            <div class="modal-content"></div>
        </div>
    </div>
</header>