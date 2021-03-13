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
                            <button class="btn btn-link">
                                <i class="la la-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </footer>
<?php

$js_files = array();
$js_files[] = array('src' => '/assets/js/jquery-3.5.1.min.js', 'defer' => true,'version' => file_get_contents(get_stylesheet_directory() . '/assets/js/jquery-3.5.1.min.js'));
$js_files[] = array('src' => '/assets/js/popper-1.14.7.min.js', 'defer' => true,'version' => file_get_contents(get_stylesheet_directory() . '/assets/js/popper-1.14.7.min.js'));
$js_files[] = array('src' => '/assets/js/bootstrap.min.js', 'defer' => true,'version' => file_get_contents(get_stylesheet_directory() . '/assets/js/bootstrap.min.js'));
$js_files[] = array('src' => '/assets/js/moment.min.js', 'defer' => false,'version' => file_get_contents(get_stylesheet_directory() . '/assets/js/moment.min.js')); //- 20 Punkte
$js_files[] = array('src' => '/assets/js/daterangepicker.min.js', 'defer' => true, 'version' => file_get_contents(get_stylesheet_directory() . '/assets/js/daterangepicker.min.js'));
$js_files[] = array('src' => '/assets/js/autocomplete.min.js', 'defer' => true, 'version' => file_get_contents(get_stylesheet_directory() . '/assets/js/autocomplete.min.js'));
$js_files[] = array('src' => '/assets/js/ion.rangeSlider.min.js', 'defer' => true, 'version' => file_get_contents(get_stylesheet_directory() . '/assets/js/ion.rangeSlider.min.js'));
$js_files[] = array('src' => '/assets/js/tiny-slider.min.js', 'defer' => false, 'version' => file_get_contents(get_stylesheet_directory() . '/assets/js/tiny-slider.min.js'));
$js_files[] = array('src' => '/assets/js/ui.min.js', 'defer' => true, 'version' => file_get_contents(get_stylesheet_directory() . '/assets/js/ui.min.js'));
$js_files[] = array('src' => '/assets/js/search.min.js', 'defer' => true, 'version' => file_get_contents(get_stylesheet_directory() . '/assets/js/search.min.js'));
$js_files[] = array('src' => '/assets/js/ajax.min.js', 'defer' => true, 'version' => file_get_contents(get_stylesheet_directory() . '/assets/js/ajax.min.js'));

/* JS inline - test performance?
echo '<script type="application/javascript">';
foreach ($js_files as $file) {
    echo '// - - - ' . basename($file) . " - - -\r\n";
    echo file_get_contents(get_stylesheet_directory() . $file) . "\r\n\r\n";
}
echo '</script>';
*/
?>
<?php
foreach ($js_files as $file) {
    ?>
    <script src="<?php echo get_stylesheet_directory_uri() . $file['src']; ?>" <?php echo !empty($file['defer']) ? 'defer' : '';?>></script>
    <?php
}
wp_footer();
?>
</body>
</html>