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
                            <div class="ibe_template_hotline">
                                <small>Service-Hotline</small><br />
                                <a href="#">+49 180 654 321</a>
                                <a class="phone-link" href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="35" height="35" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                    </svg>
                                </a>
                            </div>
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

        <footer>
            <div class="ibe_above_footer">
                <div class="container">
                    <div class="ibe_trust_item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shield-lock" width="300" height="300" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3" />
                            <circle cx="12" cy="11" r="1" />
                            <line x1="12" y1="12" x2="12" y2="14.5" />
                        </svg><br />
                        <span>SSL-Schutz</span>
                    </div>
                    <div class="ibe_trust_item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-discount" width="300" height="300" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <line x1="9" y1="15" x2="15" y2="9" />
                            <circle cx="9.5" cy="9.5" r=".5" fill="currentColor" />
                            <circle cx="14.5" cy="14.5" r=".5" fill="currentColor" />
                            <circle cx="12" cy="12" r="9" />
                        </svg><br />
                        <span>Bester Preis</span>
                    </div>
                    <div class="ibe_trust_item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-credit-card" width="300" height="300" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <rect x="3" y="5" width="18" height="14" rx="3" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                            <line x1="7" y1="15" x2="7.01" y2="15" />
                            <line x1="11" y1="15" x2="13" y2="15" />
                        </svg><br />
                        <span>Sichere Zahlung</span>
                    </div>
                    <div class="ibe_trust_item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="300" height="300" viewBox="0 0 24 24" stroke-width="1.5" stroke="#fff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <rect x="3" y="5" width="18" height="14" rx="2" />
                            <polyline points="3 7 12 13 21 7" />
                        </svg><br />
                        <span>Reise-Infos</span>
                    </div>
                </div>
            </div>

        </footer>


    </body>
    
    <script src="assets/js/jquery-3.5.1.min.js"></script>

    <script>
        
        if ($(window).width() < 900) {

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

        }
        

    </script>

</html>