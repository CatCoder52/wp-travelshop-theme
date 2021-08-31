<?php
/**
 * @todo optimize id, data tags in checkboxes
 * @var $name
 * @var $fieldname (fieldname_sectioname)
 * @var string $condition_type value is cl or c, cl = category tree is a sub tree from a object link
 * @var Pressmind\Search $search
 * @var Pressmind\Search $filter_search
 * @var $id_tree
 */

if(empty($filter_search) === false){
    $tree = new Pressmind\Search\Filter\Category($id_tree, $filter_search, $fieldname, ($condition_type == 'cl'));
    $treeItems = $tree->getResult('name');
}

/*
This code will list all items, without a Filter
$tree = new \Pressmind\ORM\Object\CategoryTree($id_tree);
$treeItems = $tree->items;
*/

$selected = array();
if(empty($_GET['pm-'.$condition_type][$fieldname]) === false && preg_match_all("/[a-zA-Z0-9\-]+(?=[,|\+]?)/", $_GET['pm-'.$condition_type][$fieldname], $matches) > 0){
    $selected = empty($matches[0]) ? array() : $matches[0];
}

if(empty($_GET['pm-'.$condition_type]) === false && key_exists($fieldname, $_GET['pm-'.$condition_type]) === true){
   // return;
}

if (empty($treeItems) === false) {
    ?>

    <div class="list-filter-box category-tree">
        <div class="list-filter-box-title">
            <strong><?php echo $name; ?></strong>
        </div>
        <div class="list-filter-box-body">
            <input type="hidden" data-behavior="OR" name="pm-<?php echo $condition_type;?>[<?php echo $fieldname;?>]" value="">

            <?php
            foreach ($treeItems as $item) {
                $uuid = 'ti-'.uniqid();
                $has_childs = !empty($item->children);

                // open the second level if neccessary
                $is_open = '';
                if(empty($selected) === false && $has_childs === true){
                    foreach ($item->children as $child_item){
                        if(in_array($child_item->id, $selected) === true){
                            $is_open = ' is--open';
                            break;
                        }
                    }
                }
                ?>
                <div class="form-check <?php echo $has_childs ? 'has-second-level' : ''; echo $is_open;?>">

                    <input class="form-check-input" type="checkbox"
                           id="<?php echo $uuid; ?>"
                           data-id-parent=""
                           data-id="<?php echo $item->id; ?>"
                           data-name="<?php echo $fieldname;?>"
                           data-type="<?php echo $condition_type;?>"
                    <?php echo in_array($item->id, $selected) ? 'checked' : '';?>
                            <?php echo !empty($is_open) ? 'disabled' : '';?>
                    ><span><i
                        ><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler-check" width="12" height="12" viewBox="0 0 24 24" stroke-width="3" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
  <path stroke="none" d="M0 0h24v24H0z"/>
  <path d="M5 12l5 5l10 -10" />
</svg></i></span>
                    <label class="form-check-label" for="<?php echo $uuid; ?>">
                        <?php echo $item->name; ?>
                    </label>

                    <?php if ($has_childs === true) { ?>

                        <button type="button" class="toggle-second-level" >
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler-dots-circle-horizontal" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#607D8B" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z"/>
                                <circle cx="12" cy="12" r="9" />
                                <line x1="8" y1="12" x2="8" y2="12.01" />
                                <line x1="12" y1="12" x2="12" y2="12.01" />
                                <line x1="16" y1="12" x2="16" y2="12.01" />
                            </svg>
                        </button>

                        <div class="list-filter-second-level">

                            <?php foreach ($item->children as $child_item) {
                                $uuid = 'ti-'.uniqid();
                                ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                           id="<?php echo $uuid; ?>"
                                           data-id-parent="<?php echo $item->id; ?>"
                                           data-id="<?php echo $child_item->id; ?>"
                                           data-name="<?php echo $fieldname;?>"
                                           data-type="<?php echo $condition_type;?>"
                                        <?php echo in_array($child_item->id, $selected) ? 'checked' : '';?>
                                           ><span><i><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler-check" width="12" height="12" viewBox="0 0 24 24" stroke-width="3" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
  <path stroke="none" d="M0 0h24v24H0z"/>
  <path d="M5 12l5 5l10 -10" />
</svg></i></span>
                                    <label class="form-check-label" for="<?php echo $uuid; ?>">
                                        <?php echo $child_item->name; ?>
                                    </label>
                                </div>

                            <?php } ?>

                        </div>

                    <?php } ?>


                </div>

                <?php
            }
            ?>
        </div>
    </div>
<?php } ?>