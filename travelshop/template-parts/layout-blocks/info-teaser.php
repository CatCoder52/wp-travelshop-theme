<section class="content-block content-block-teaser-group">
    <div class="row">
        <div class="col-12">
            <h2 class="mt-0">
                Info-Teaser
            </h2>
            <p>
               Diese Teaser basieren auf dem WordPress PostType "Beiträge".
                <br>
                <span class="small">Template: wp-content/themes/travelshop/template-parts/layout-blocks/info-teaser.php</span>
            </p>
        </div>
        <?php
        $posts = get_posts(array('numberposts' => 8, 'order' => 'desc'));
        foreach($posts as $p){
            load_template(get_template_directory().'/template-parts/wp-views/info-teaser-view.php', false, $p);
        }
        ?>
    </div>
</section>
