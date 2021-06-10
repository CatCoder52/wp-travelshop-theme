<?php require_once('../../../wp-load.php'); ?>
<?php
get_header();
?>

<main>
    <div class="container">
        ###PRESSMIND_IBE_CONTENT###
    </div>
</main>

<?php
get_footer();
?>

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
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="16" height="16" viewBox="0 4 25 24" stroke-width="2" stroke="#607D8B" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                        </svg> <a href="tel:01234">01234 567889</a><br>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="16" height="16" viewBox="0 2 24 24" stroke-width="1.5" stroke="#607D8B" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <rect x="3" y="5" width="18" height="14" rx="2" />
                            <polyline points="3 7 12 13 21 7" />
                        </svg> <a href="mailto:info@example.de">info@example.de</a>
                    </p>
                </div>

                <div class="col-12 col-sm-6 col-lg-3 offset-lg-6">
                    <?php
                    if (has_nav_menu('ibe_footer')) {

                        $locations = get_nav_menu_locations(); //get all menu locations
                        $footer_1_menu = wp_get_nav_menu_object($locations['ibe_footer']);

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
                                        'theme_location' => 'ibe_footer',
                                    )
                                );
                                ?>
                            </ul>
                        </nav>

                    <?php } else { ?>
                        <nav class="navbar flex-column">
                            <small style="padding: 1rem; display: inline-block;">menu: ‚IBE Template Footer Menu‘ not
                                configured</small>
                        </nav>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

</footer>

<!--###PRESSMIND_IBE_FOOTER_SCRIPTS###-->

<?php
// don't load bootstrap or jquery here, it's already loaded during the <!--###PRESSMIND_IBE_FOOTER_SCRIPTS###--> tag above
?>
</body>
</html>