<?php

namespace Pressmind\Travelshop;

class Search
{
    /**
     * @param $request
     * @param $page_size
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
     * @return array
     * @throws \Exception
     */
    public static function getResult($request, $occupancy = 2, $page_size = 12, $getFilters = false, $returnFiltersOnly = false)
    {

        if (empty($request['pm-ho']) === true) {
            // if the price duration slider is active, we have to set the housing occupancy search
            // (to display the correct search result with the correct cheapeast price inside)
            $request['pm-ho'] = $occupancy;
        }

        if($getFilters){
            $FilterCondition = [];
            if(!empty($request['pm-ot'])){
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
            $item['dates_per_month'] = [];
            if(!empty($document['dates_per_month'])){
                $item['dates_per_month'] = $document['dates_per_month'];
                foreach($document['dates_per_month'] as $k => $month){
                    foreach($month['five_dates_in_month'] as $k1 => $date){
                        $item['dates_per_month'][$k]['five_dates_in_month'][$k1]['date_departure'] = new \DateTime($date['date_departure']);
                        $item['dates_per_month'][$k]['five_dates_in_month'][$k1]['date_arrival'] = new \DateTime($date['date_arrival']);
                    }
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
                $item['cheapest_price']->option_board_type = $document['prices']['option_board_type'];
            }else{
                $document['prices'] = null;
            }
            $item['departure_date_count'] = $document['departure_date_count'];
            $item['possible_durations'] = !empty($document['possible_durations']) ? $document['possible_durations'] : [];
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
                'aggregation_pipeline_filter' => !empty($filter) ? $filter->buildQueryAsJson($getFilters) : null,
                'aggregation_pipeline_search' => !empty($search) ? $search->buildQueryAsJson($getFilters) : null
            ]
        ];
    }
}