<?php


namespace Pressmind\Travelshop;

class CategoryTreeTools
{

    /**
     * Flatten the multi dimension tree to a simple leaf list, each leaf has it's human readable path
     * @param \Pressmind\ORM\Object\CategoryTree\Item[] $tree
     * @param \Pressmind\ORM\Object\CategoryTree\Item[] | null $parent
     *
     *
     * <code>
     * // Output Example
     * Array
     *       (
     *           [0] => Array
     *           (
     *               [name] => Italien
     *               [value] => 304E15ED-302F-CD33-9153-14B8C6F955BD
     *           )
     *           [1] => Array
     *               (
     *               [name] => Italien › Rom
     *               [value] => k0CC74062-5FFA-989C-28F7-E019881201A1
     *           )
     *           [2] => Array
     *               (
     *               [name] => Italien › Toskana
     *               [value] => k8A141383-A270-B9BD-A9E9-E0910A679CA9
     *           )
     *      )
     * </code>
     * @return array
     */
    public static function flatten($tree, $parent = null) {
        $output = array();

        if($parent !== null) {
            $parent = $parent.' › ';
        }
        //loop through the tree array
        foreach($tree as $k => $Item) {
            if(!empty($Item->children) && is_array($Item->children)) {
                $currentPath = $parent.$Item->name;
                $output[] = [
                    'name' => $currentPath,
                    'value' => $Item->id,
                ];
                $output = array_merge($output, self::flatten($Item->children, $currentPath));
            } else {
               $output[] = [
                    'name' => $Item->name,
                    'value' => $Item->id,
                ];
            }
        }
        return $output;
    }


}