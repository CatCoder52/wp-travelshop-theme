<footer class="footer-main">
    <div class="container">
        <div class="row footer-boxes">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="h5">
                    Kontakt
                </div>
                <p>
                    <strong>Touroperator GmbH</strong><br>
                    Urlaubsgasse 1<br>
                    54321 Musterstadt
                </p>
                <p>
                    <a href="tel:01234"><i class="la la-phone"></i> 01234 567889</a><br>
                    <a href="mailto:info@example.de"><i class="la la-envelope"></i> info@example.de</a>
                </p>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <?php
                if (has_nav_menu('footer_column_1')) {

                    $locations = get_nav_menu_locations(); //get all menu locations
                    $footer_1_menu = wp_get_nav_menu_object($locations['footer_column_1']);

                    ?>
                    <div class="h5">
                        <?php echo !empty($footer_1_menu->name) ? $footer_1_menu->name : ''; ?>
                    </div>
                    <nav class="nav flex-column">
                        <ul class="">
                            <?php
                            wp_nav_menu(
                                array(
                                    'container' => '',
                                    'depth' => 1,
                                    'items_wrap' => '%3$s',
                                    'theme_location' => 'footer_column_1',
                                )
                            );
                            ?>
                        </ul>
                    </nav>
                <?php } ?>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <?php if (has_nav_menu('footer_column_2')) {

                    $locations = get_nav_menu_locations(); //get all menu locations
                    $footer_2_menu = wp_get_nav_menu_object($locations['footer_column_2']);

                    ?>
                    <div class="h5">
                        <?php echo !empty($footer_2_menu->name) ? $footer_2_menu->name : ''; ?>
                    </div>
                    <nav class="nav flex-column">
                        <ul class="">
                            <?php
                            wp_nav_menu(
                                array(
                                    'container' => '',
                                    'depth' => 1,
                                    'items_wrap' => '%3$s',
                                    'theme_location' => 'footer_column_2',
                                )
                            );
                            ?>
                        </ul>
                    </nav>
                <?php } ?>


                <div class="h5">
                    Searchroutes
                </div>
                <?php
                // For Example purposes only, output all search routes
                echo do_shortcode('[ts-searchroutes]');
                ?>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <div class="h5">
                    Newsletter
                </div>
                <p>
                    Abonniere unseren Newsletter und verpasse keine Aktion!
                </p>

                <form class="input-group mt-4" action="#" method="post">
                    <input class="form-control" type="text" placeholder="E-Mail Adresse">
                    <div class="input-group-append">
                        <button class="btn btn-link" aria-label="Anmelden">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24"
                                 height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#607D8B" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="10" y1="14" x2="21" y2="3"/>
                                <path d="M21 3l-6.5 18a0.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a0.55 .55 0 0 1 0 -1l18 -6.5"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</footer>
<?php
wp_footer();
?>
</body>
</html>