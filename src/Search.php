<?php

namespace Pressmind\Travelshop;

class Search
{
    /**
     * @var string
     */
    private static $engine = 'mongodb';

    public static function setEngine($engine)
    {
        self::$engine = $engine;
    }

    /**
     * @param $request
     * @param $id_object_type_default
     * @param int $occupancy_default
     * @param int $page_size
     * <code>
     * return ['total_result' => 100,
     *            'current_page' => 1,
     *            'pages' => 10,
     *            'page_size' => 10,
     *            'cache' => [
     *              'is_cached' => false,
     *              'info' => []
     *            ],
     *            'items' => [],
     *            'mongodb' => [
     *              'aggregation_pipeline' => ''
     *            ]
     *           ];
     * </code>
     * @return array|void
     */
    public static function getResult($request, $occupancy_default = 2, $page_size = 12, $getFilters = false, $returnFiltersOnly = false)
    {
        if (empty($request['pm-ho']) === true) {
            // if the price duration slider is active, we have to set the housing occupancy search
            // (to display the correct search result with the correct cheapeast price inside)
            $request['pm-ho'] = $occupancy_default;
        }
        if (self::$engine == 'mysql') {
            return self::searchMySql($request, $page_size, $getFilters, $returnFiltersOnly);
        }
        if (self::$engine == 'mongodb') {
            return self::searchMongoDB($request, $occupancy_default, $page_size, $getFilters, $returnFiltersOnly);
        }
    }

    /**
     * @param $request
     * @param $page_size
     * @return array
     * @throws \Exception
     */
    private static function searchMySql($request, $page_size, $getFilters = false, $returnFiltersOnly = false)
    {
        // @TODO rebuild! this code is a pasteboard
        return;
        $search = \BuildSearch::fromRequest($request, 'pm', true, $page_size);
        if (!empty($request['update_cache'])) {
            $mediaObjects = $search->getResults();
            $cacheinfo = $search->getCacheInfo();
            if (!empty($cacheinfo)) {
                echo 'update_cache';
                echo '<pre>' . print_r($cacheinfo, true) . '</pre>';
                $search->updateCache($cacheinfo['info']->parameters);
            }
        }
        if (!empty($request['no_cache'])) {
            $search->disableCache();
        }
        $mediaObjects = $search->getResults();
        $items = [];
        foreach ($mediaObjects as $mediaObject) {
            $items[] = $mediaObject;
        }

        /**
         * @var \Pressmind\Search $search
         */
        if(empty($search) === false){

            // get the min and max price, based on the current search
            $pRangeFilter = new Pressmind\Search\Filter\PriceRange($search);
            $pRange = $pRangeFilter->getResult();

            if(empty($pRange->min) || empty($pRange->max)){
                return;
            }

            // set the price range to the closest 100, 1000 and so on...
            $pRange->min = str_pad(substr(round($pRange->min), 0,1), strlen(round($pRange->min)), 0);
            $pRange->max = str_pad(substr(round($pRange->max) , 0,1)+1, strlen(round($pRange->max)) + strlen(substr(round($pRange->max), 0,1)+1)-1, 0);

        }

        if(empty($filter_search) === false){
            $tree = new Pressmind\Search\Filter\Category($id_tree, $filter_search, $fieldname, ($condition_type == 'cl'));
            $treeItems = $tree->getResult('name');
        }

        /*
        This code will list all items, without a Filter
        $tree = new \Pressmind\ORM\Object\CategoryTree($id_tree);
        $treeItems = $tree->items;
        */

        /**
         * Get the current min/max daterange for this object type and .
         * Use the wp transient cache for a better performance
         */
        $transient = 'ts_min_max_date_range_'.md5(serialize($search->getConditions()));
        if (function_exists('get_transient') === false || $dRange = get_transient( $transient) === false) {
            $dRangeFilter = new Pressmind\Search\Filter\DepartureDate($search);
            $dRange = $dRangeFilter->getResult();
            if(function_exists('set_transient')){
                set_transient($transient, $dRange, 60);
            }
        }

        $minDate = $maxDate = '';
        if(!empty($dRange->from) && !empty($dRange->to)){
            $minDate = $dRange->from->format('d.m.Y');
            $maxDate = $dRange->to->format('d.m.Y');
        }

        return [
            'total_result' => $search->getTotalResultCount(),
            'current_page' => $search->getPaginator()->getCurrentPage(),
            'pages' => $search->getPaginator()->getTotalPages(),
            'page_size' => $page_size,
            'cache' => [
                'is_cached' => $search->isCached(),
                'info' => $search->getCacheInfo()
            ],
            'items' => $items
        ];

    }

    /**
     * @param $request
     * @param $page_size
     * @return array
     * @throws \Exception
     */
    private static function searchMongoDB($request, $occupancy, $page_size, $getFilters = false, $returnFiltersOnly = false)
    {
        if($getFilters){
            $FilterCondition = [];
            if(!empty((int)$request['pm-ot'])){
                $FilterCondition[] =  new \Pressmind\Search\Condition\MongoDB\ObjectType((int)$request['pm-ot']);
            }
            $FilterCondition[] = new \Pressmind\Search\Condition\MongoDB\Occupancy($occupancy);
            $filter = new \Pressmind\Search\MongoDB( $FilterCondition, ['price_total' => 'asc'], TS_LANGUAGE_CODE);
            $result_filter = $filter->getResult(true, true);
        }
        $search = \BuildSearch::fromRequestMongoDB($request, 'pm', true, $page_size);
        $result = $search->getResult($getFilters, false);
        $items = [];
        foreach ($result->documents as $document) {
            $document = json_decode(json_encode($document), true);
            $item = (array)$document['description'];
            $item['id_media_object'] = $document['id_media_object'];
            $item['id_object_type'] = $document['id_object_type'];
            $item['url'] = $document['url'];
            $item['dates_per_month'] = $document['dates_per_month'];
            foreach($item['dates_per_month'] as $k => $month){
                foreach($month['five_dates_in_month'] as $k1 => $date){
                    $item['dates_per_month'][$k]['five_dates_in_month'][$k1]['date_departure'] = new \DateTime($date['date_departure']);
                    $item['dates_per_month'][$k]['five_dates_in_month'][$k1]['date_arrival'] = new \DateTime($date['date_arrival']);
                }
            }
            $item['possible_durations'] = !empty($document['possible_durations']) ? $document['possible_durations'] : [];
            $item['last_modified_date'] = $document['last_modified_date'];
            if(!empty($document['prices'])){
                $item['cheapest_price'] = new \stdClass();
                $item['cheapest_price']->duration = $document['prices']['duration'];
                $item['cheapest_price']->price_total = $document['prices']['price_total'];
                $item['cheapest_price']->price_regular_before_discount = $document['prices']['price_regular_before_discount'];
                $item['cheapest_price']->earlybird_discount = $document['prices']['earlybird_discount'];
                $item['cheapest_price']->earlybird_discount_f = $document['prices']['earlybird_discount_f'];
                $item['cheapest_price']->date_departure = new \DateTime($document['prices']['date_departure']);
                $item['cheapest_price']->date_arrival = new \DateTime($document['prices']['date_arrival']);
                $item['cheapest_price']->departure_range_from = new \DateTime($document['prices']['departure_range_from']);
                $item['cheapest_price']->departure_range_to = new \DateTime($document['prices']['departure_range_to']);
                $item['cheapest_price']->earlybird_discount_date_to = new \DateTime($document['prices']['earlybird_discount_date_to']);
            }else{
                $document['prices'] = null;
            }
            $item['departure_date_count'] = $document['departure_date_count'];
            $item['possible_durations'] = $document['possible_durations'];
            //$item['best_price_meta'] = $document['best_price_meta'];
            $items[] = $item;
        }
        $categories = [];
        if(!empty($result_filter->categoriesGrouped)){
            foreach(json_decode(json_encode($result_filter->categoriesGrouped)) as $item){
                $categories[$item->_id->field_name][$item->_id->level][$item->_id->id_item] = $item->_id;
            }
        }
        return [
            'total_result' => $result->total,
            'current_page' => $result->currentPage,
            'pages' => $result->pages,
            'page_size' => $page_size,
            'cache' => [
                'is_cached' => false,
                'info' => []
            ],
            'id_object_type' => !empty($request['pm-ot']) ? $request['pm-ot'] : null,
            'categories' => $categories,
            'duration_min' => !empty($result_filter->minDuration) ? $result_filter->minDuration : null,
            'duration_max' => !empty($result_filter->maxDuration) ? $result_filter->maxDuration : null,
            'departure_min' => !empty($result_filter->minDeparture) ? new \DateTime($result_filter->minDeparture) : null,
            'departure_max' => !empty($result_filter->maxDeparture) ? new \DateTime($result_filter->maxDeparture) : null,
            'price_min' => !empty($result_filter->minPrice) ? $result_filter->minPrice  : null,
            'price_max' => !empty($result_filter->maxPrice) ? $result_filter->maxPrice : null,
            'items' => $items,
            'mongodb' => [
                'aggregation_pipeline' => json_encode($search->buildQuery())
            ]
        ];
    }
}