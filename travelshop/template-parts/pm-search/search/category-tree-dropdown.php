<?php
/**
 * @todo optimize id & data tags in checkboxes
 * @var $name
 * @var $fieldname (feldname_sectioname)
 *
 * @var $id_tree
 */


$tree = new Pressmind\Search\Filter\Category($id_tree, $search);
$treeItems = $tree->getResult();


/*
This code will list all items, without a Filter
$tree = new \Pressmind\ORM\Object\CategoryTree($id_tree);
$treeItems = $tree->items;
*/

//$tree = \Pressmind\ORM\Object\CategoryTree::findForMediaObjectType($id_tree, $fieldname);
//$tree2 = \Pressmind\ORM\Object\CategoryTree::findForMediaObjectType("Tagesfahrt", 'reiseart_default');

$selected = array();
if(empty($_GET['pm-c'][$fieldname]) === false && preg_match_all("/[a-zA-Z0-9\-]+(?=[,|\+]?)/", $_GET['pm-c'][$fieldname], $matches) > 0){
    $selected = empty($matches[0]) ? array() : $matches[0];
}

if (empty($treeItems) === false) {
    ?>

    <div class="form-group mb-md-0 category-tree">
        <label for=""><?php echo $name; ?></label>
        <div class="dropdown">

            <button class="select-from-control dropdown-toggle" type="button"
                    id="dropdownReiseziel" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                <span class="selected-options" data-placeholder="Bitte wählen">Bitte wählen</span>

                <i class="la la-angle-down"></i>
            </button>

            <div class="dropdown-menu dropdown-menu-select"
                 aria-labelledby="dropdownReiseziel">
                <div class="multi-level-checkboxes">

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
                <button class="btn btn-outline-secondary btn-block mt-3 filter-prompt">
                    Auswahl übernehmen
                </button>
            </div>
        </div>

    </div>

<?php } ?>