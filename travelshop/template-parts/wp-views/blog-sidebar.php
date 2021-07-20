<div class="blog-sidebar">

    <div class="teaser teaser-blog-sidebar teaser-blog-sidebar--search">
        <div class="teaser-body">
            <?= get_search_form(); ?>
        </div>
    </div>

    <div class="teaser teaser-blog-slidebar">
        <div class="teaser-body">
            <h4>Kategorien</h4>

            <div class="post-categories">
                <?php
                $categories = get_categories();

                foreach ( $categories as $category ) {
                    $category_link = get_category_link( $category );
                    ?>
                    <div class="post-tag">
                        <a href="<?= $category_link; ?>" title='<?= $category->name; ?>' class='<?= $category->slug; ?>'>
                            <?= $category->name; ?> (<?= $category->count; ?>)
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>

        </div>
    </div>

    <div class="teaser teaser-blog-slidebar">
        <div class="teaser-body">
            <h4>Stichworte</h4>

            <div class="post-tags">

                <?php

                $tags = get_tags();

                foreach ( $tags as $tag ) {
                    $tag_link = get_tag_link( $tag->term_id );
                    ?>
                        <a class="badge badge-secondary" href="<?= $tag_link; ?>" title='<?= $tag->name; ?>' class='<?= $tag->slug; ?>'>
                            <?= $tag->name; ?>
                        </a>
                    <?php
                }
                ?>
            </div>

        </div>
    </div>

</div>