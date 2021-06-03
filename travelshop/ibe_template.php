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

<!--###PRESSMIND_IBE_FOOTER_SCRIPTS###-->

<?php
// don't load bootstrap or jquery here, it's already loaded during the <!--###PRESSMIND_IBE_FOOTER_SCRIPTS###--> tag above
?>
</body>
</html>