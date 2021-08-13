    <?php
/**
 * @todo optimize id & data tags in checkboxes
 * @var $name
 * @var $fieldname (fieldname_sectionname)
 * @var string $condition_type value is cl or c, cl = category tree is a sub tree from a object link

 * @var $search
 * @var $id_tree
 */


$tree = new Pressmind\Search\Filter\Category($id_tree, $search, $fieldname, ($condition_type == 'cl'));
$treeItems = $tree->getResult();

/*
This code will list all items, without a Filter
$tree = new \Pressmind\ORM\Object\CategoryTree($id_tree);
$treeItems = $tree->items;
*/

//$tree = \Pressmind\ORM\Object\CategoryTree::findForMediaObjectType($id_tree, $fieldname);
//$tree2 = \Pressmind\ORM\Object\CategoryTree::findForMediaObjectType("Tagesfahrt", 'reiseart_default');

$selected = array();
if(empty($_GET['pm-'.$condition_type][$fieldname]) === false && preg_match_all("/[a-zA-Z0-9\-]+(?=[,|\+]?)/", $_GET['pm-'.$condition_type][$fieldname], $matches) > 0){
    $selected = empty($matches[0]) ? array() : $matches[0];
}

if (empty($treeItems) === false) {
    ?>

    <div class="form-group mb-md-0 category-tree">
        <label for=""><?php echo $name; ?></label>
        <div class="dropdown">

            <button class="dropdownReiseziel select-from-control dropdown-toggle" type="button"
                    data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                <span class="selected-options" data-placeholder="bitte wählen">bitte wählen</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x dropdown-clear" width="30" height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>

            <div class="dropdown-menu dropdown-menu-select"
                 aria-labelledby="dropdownReiseziel">
                <div class="multi-level-checkboxes">
                    <input type="hidden" data-behavior="OR" name="pm-<?php echo $condition_type;?>[<?php echo $fieldname;?>]" value="">

                    <?php
                    foreach ($treeItems as $item) {
                        $uuid = 'ti-'.uniqid();
                        $item->toStdClass();
                        $has_childs = !empty($item->children);
                        ?>
                        <div class="form-check <?php echo $has_childs ? 'has-second-level' : ''; ?>">
                            <input class="form-check-input" type="checkbox"
                                   data-id-parent="" data-id="<?php echo $item->id; ?>"
                                   data-name="<?php echo $fieldname; ?>"
                                   data-type="<?php echo $condition_type;?>"
                                   id="<?php echo $uuid; ?>"
                                    <?php echo in_array($item->id, $selected) ? 'checked' : '';?>><span><i><svg xmlns="http://www.w3.org/2000/svg"
                                                                                class="icon icon-tabler-check"
                                                                                width="12" height="12"
                                                                                viewBox="0 0 24 24"
                                                                                stroke-width="3" stroke="#ffffff"
                                                                                fill="none"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round">
  <path stroke="none" d="M0 0h24v24H0z"/>
  <path d="M5 12l5 5l10 -10"/>
</svg></i></span>
                            <label class="form-check-label" for="<?php echo $uuid; ?>">
                                <?php echo $item->name; ?>
                            </label>


                            <?php /* if ($has_childs === true) { ?>

                                <div class="list-filter-second-level">
                                    <?php foreach ($item->children as $child_item) {
                                        $uuid = 'ti-'.uniqid();
                                        ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   id="<?php echo $uuid; ?>"
                                                   data-id-parent="<?php echo $item->id; ?>"
                                                   data-id="<?php echo $child_item->id; ?>"
                                                   data-name="<?php echo $fieldname; ?>"><span><i><svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-check" width="12"
                                                            height="12" viewBox="0 0 24 24" stroke-width="3"
                                                            stroke="#ffffff" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
  <path stroke="none" d="M0 0h24v24H0z"/>
  <path d="M5 12l5 5l10 -10"/>
</svg></i></span>
                                            <label class="form-check-label"
                                                   for="<?php echo $uuid; ?>">
                                                <?php echo $child_item->name; ?>                                            </label>
                                        </div>
                                    <?php } ?>


                                </div>

                            <?php } */ ?>


                        </div>


                        <?php
                    }
                    ?>
                </div>
                <button class="btn btn-primary btn-block mt-3 filter-prompt">
                    Auswahl übernehmen
                </button>
            </div>
        </div>

    </div>

<?php } ?>