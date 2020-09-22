<?php
$has_footer_1_menu = has_nav_menu( 'footer_column_1' );
$has_footer_2_menu = has_nav_menu( 'footer_column_2' );
?>

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
                <?php if($has_footer_1_menu){

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
                            'container'      => '',
                            'depth'          => 1,
                            'items_wrap'     => '%3$s',
                            'theme_location' => 'footer_column_1',
                        )
                    );
                    ?>
                    </ul>
                </nav>
                <?php } ?>
            </div>

            <div class="col-12 col-sm-6 col-lg-3">
                <?php if($has_footer_2_menu){

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
                                    'container'      => '',
                                    'depth'          => 1,
                                    'items_wrap'     => '%3$s',
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

                <form class="input-group mt-4" action="#" method="post" >
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


<!--
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/bootstrap.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/moment.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/daterangepicker.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/app.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
-->
<script type="application/javascript">
<?php

$js_files = array();
$js_files[] = get_stylesheet_directory().'/assets/js/jquery-3.5.1.min.js';
$js_files[] = get_stylesheet_directory().'/assets/js/popper-1.14.7.min.js';
$js_files[] = get_stylesheet_directory().'/assets/js/bootstrap.min.js';
$js_files[] = get_stylesheet_directory().'/assets/js/moment.min.js'; //- 20 Punkte
$js_files[] = get_stylesheet_directory().'/assets/js/daterangepicker.min.js';
$js_files[] = get_stylesheet_directory().'/assets/js/autocomplete.min.js';
$js_files[] = get_stylesheet_directory().'/assets/js/ion.rangeSlider.min.js';
$js_files[] = get_stylesheet_directory().'/assets/js/tiny-slider.min.js';
$js_files[] = get_stylesheet_directory().'/assets/js/ui.min.js';
$js_files[] = get_stylesheet_directory().'/assets/js/search.min.js';
$js_files[] = get_stylesheet_directory().'/assets/js/ajax.min.js';

foreach($js_files as $file){
    echo '// - - - '.basename($file)." - - -\r\n";
    echo file_get_contents($file)."\r\n\r\n";
}

?>
</script>
<?php
wp_footer();
?>
</body>
</html>