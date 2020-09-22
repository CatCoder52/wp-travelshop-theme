<?php
/**
 * @var int $page_size
 */

?>
<div class="row">
    <div class="col-12">
        <nav aria-label="Page navigation example">
            <ul class="ajax-enabled-pagination pagination">

                <li class="page-item<?php echo ($current_page == 1) ? ' disabled' : ''; ?>"><a class="page-link"
                                                                                               href="?<?php echo BuildSearch::getCurrentQueryString($current_page - 1, $page_size); ?>">Previous</a>
                </li>
                <?php
                for ($page = 1; $page <= $pages; $page++) {
                    ?>
                    <li class="page-item<?php echo ($current_page == $page) ? ' active' : ''; ?>"><a
                            class="page-link"
                            href="?<?php echo BuildSearch::getCurrentQueryString($page, $page_size); ?>"><?php echo $page; ?></a>
                    </li>
                <?php } ?>
                <li class="page-item<?php echo ($current_page == $pages) ? ' disabled' : ''; ?>"><a
                        class="page-link"
                        href="?<?php echo BuildSearch::getCurrentQueryString($current_page + 1, $page_size); ?>">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</div>