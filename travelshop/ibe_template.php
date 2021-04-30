<?php require_once('../../../wp-load.php'); ?>
<!DOCTYPE html>
<html lang="de">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/scss/ibe_template.css">
        <title>Travelshop - Buchung</title>

    </head>

    <body>

        <header>
            <div class="container">
               
                <!-- Header Logo  -->
                <img class="logo" src="assets/img/travelshop-logo.svg" alt="Travelshop" />

                <!-- Header Menu  -->
                <?php 
                    $menu_items = wpse_nav_menu_2_tree('ibe_head');
                    if(isset($menu_items)) { ?>
                        <nav id="ibe_main_nav">
                            <ul>
                                <?php foreach ($menu_items as $item) { ?>

                                    <?php if (empty($item->wpse_children) === true) { ?> <!-- // Level 1 -->
                                        <li class="nav-item">
                                            <a class="nav-link"
                                            href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a>
                                        </li>
                                    <?php } else { ?> <!-- // Level 2 -->
                                        <li class="nav-item dropdown">
                                            <a class="nav-link nav-link-dropdown" href="#" id="navbarDropdown"
                                            role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <?php echo $item->title; ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down dropdown-toggle" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <polyline points="6 9 12 15 18 9" />
                                                </svg>
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
                                } ?>
                            </ul>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x ibe_menu_close" width="35" height="35" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </nav>
                    <?php } ?>

                    <div class="ibe_mobile_menu_toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2" width="30" height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <line x1="4" y1="6" x2="20" y2="6" />
                            <line x1="4" y1="12" x2="20" y2="12" />
                            <line x1="4" y1="18" x2="20" y2="18" />
                        </svg>
                    </div>

            </div>
        </header>


    </body>
    
    <script src="assets/js/jquery-3.5.1.min.js"></script>

    <script>
        
        // MOBILE - Navbar Open Event
        $('.ibe_mobile_menu_toggle').click((e) => {
            e.stopPropagation();
            $(e.target).siblings('#ibe_main_nav').toggleClass('active');
        });

        // MOBILE - Navbar Close Event
        $(window).click(() => {
            $('#ibe_main_nav').removeClass('active');
        });
        $('.ibe_menu_close').click((e) => {
            $(e.target).parent().removeClass('active');
        });

        // MOBILE - Prevent Navbar Closing By Clicking On Navigation or Toggle
        $('#ibe_main_nav').click(() => {
            event.stopPropagation() ;
        });

        // MOBILE - Dropdown Toggle Function
        $('.dropdown-toggle').click((e) => {
            $(e.target).parent().parent().toggleClass('active');
        });

    </script>

</html>