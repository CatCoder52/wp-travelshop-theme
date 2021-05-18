<?php

class BuildSearch
{

    /**
     * Contains the current GET request as validated array
     * @var array
     */
    private static $current_search_query_string;
    private static $page_size = 10;
    private static $page = 1;

    /*
     *
     * Building a pressmind Search Query based on GET or POST Request
     *
     * Possible Parameters
     * $_GET['pm-id'] media object id/s  separated by comma
     * $_GET['pm-ot'] object Type ID
     * $_GET['pm-t'] term
     * $_GET['pm-c'] category id's separated by comma (search with "or") or plus (search with "and")   e.g. pm-c[land_default]=xxx,yyyy = or Suche, + and Suche
     * $_GET['pm-pr'] price range 123-1234
     * $_GET['pm-dr'] date range 20200101-20200202
     * $_GET['pm-vi'] visibiltiy
     * $_GET['pm-st'] state
     * $_GET['pm-bs'] booking state (date)
     * $_GET['pm-po'] pool
     * $_GET['pm-br'] brand
     * $_GET['pm-vr'] valid from, valid to range
     * $_GET['pm-l'] limit 0,10
     * $_GET['pm-o'] order
     * @param $request
     * @return \Pressmind\Search
     */
    public static function fromRequest($request, $prefix = 'pm', $paginator = true, $page_size = 10)
    {

        array_walk_recursive($request, function($key, &$item){
            $item = urldecode($item);
        });

        $validated_search_parameters = [];
        $conditions = array();

        // set the default visibility
        $conditions[] = Pressmind\Search\Condition\Visibility::create(TS_VISIBILTY);

        if (empty($id_object_type = intval($request[$prefix.'-ot'])) === false) {
            $conditions[] = Pressmind\Search\Condition\ObjectType::create($id_object_type);
            $validated_search_parameters[$prefix.'-ot'] = $id_object_type;
        }


        if (empty($request[$prefix.'-t']) === false){
            $term = $request[$prefix.'-t'];
            $conditions[] = Pressmind\Search\Condition\Fulltext::create($term, ['fulltext'], 'AND', 'NATURAL LANGUAGE MODE');
            $validated_search_parameters[$prefix.'-t'] = $request[$prefix.'-t'];
        }


        if (isset($request[$prefix.'-pr']) === true && preg_match('/^([0-9]+)\-([0-9]+)$/', $request[$prefix.'-pr']) > 0) {
            list($price_range_from, $price_range_to) = explode('-', $request[$prefix.'-pr']);
            $price_range_from = empty(intval($price_range_from)) ? 1 : intval($price_range_from);
            $price_range_to = empty(intval($price_range_to)) ? 99999 : intval($price_range_to);
            $conditions[] = Pressmind\Search\Condition\PriceRange::create($price_range_from, $price_range_to);
            $validated_search_parameters[$prefix.'-pr'] = $price_range_from.'-'.$price_range_to;

        }

        if (isset($request[$prefix.'-du']) === true && preg_match('/^([0-9]+)\-([0-9]+)$/', $request[$prefix.'-du']) > 0) {
            list($duration_range_from, $duration_range_to) = explode('-', $request[$prefix.'-du']);
            $duration_range_from = empty(intval($duration_range_from)) ? 1 : intval($duration_range_from);
            $duration_range_to = empty(intval($duration_range_to)) ? 99999 : intval($duration_range_to);
            $conditions[] = Pressmind\Search\Condition\DurationRange::create($duration_range_from, $duration_range_to);
            $validated_search_parameters[$prefix.'-du'] = $duration_range_from.'-'.$duration_range_to;
        }


        if (isset($request[$prefix.'-dr']) === true) {
            $dateRange = self::extractDaterange($request[$prefix.'-dr']);
            if($dateRange !== false){
                list($from, $to) = $dateRange;
                $conditions[] = Pressmind\Search\Condition\DateRange::create($from, $to);
                $validated_search_parameters[$prefix.'-dr'] = $from->format('Y-m-d').'-'.$to->format('Y-m-d');
            }
        }


        if (isset($request[$prefix.'-c']) === true && is_array($request[$prefix.'-c']) == true) {

            foreach($request[$prefix.'-c'] as $property_name => $item_ids){

                if(preg_match('/^[0-9a-zA-Z\-\_]+$/', $property_name) > 0){ // valid property name

                    if(preg_match('/^[0-9a-zA-Z\-\,]+$/', $item_ids) > 0){ // search by OR, marked by ","
                        $delimiter = ',';
                        $operator = 'OR';
                    }elseif(preg_match('/^[0-9a-zA-Z\-\+]+$/', $item_ids) > 0){ // search by AND, marked by "+"
                        $delimiter = '+';
                        $operator = 'AND';
                    }else{ // not valid
                        continue;
                    }

                    $item_ids = explode($delimiter,$item_ids);
                    $conditions[] = Pressmind\Search\Condition\Category::create($property_name, $item_ids, $operator);
                    $validated_search_parameters[$prefix.'-c'][$property_name] = implode($delimiter, $item_ids);
                }

            }
        }


        $order = array();
        $allowed_orders = array('rand', 'price-desc', 'price-asc', 'name-asc', 'name-desc', 'code-asc', 'code-desc');

        if (empty($request[$prefix.'-o']) === false && in_array($request[$prefix.'-o'], $allowed_orders) === true) {

            if($request[$prefix.'-o'] == 'rand'){
                $order = array('' => 'RAND()');
            }else{
                list($property, $direction) =  explode('-', $request[$prefix.'-o']);
                $order = array($property => $direction);

                // we need a price range to order by price, so we have to change the search
                if($property == 'price' && empty($price_range_from) && empty($price_range_to)){
                    $conditions[] = Pressmind\Search\Condition\PriceRange::create(1, 9999);
                    $validated_search_parameters[$prefix.'-pr'] = '1-9999';
                    // reset the paginator, because we have modified the search
                    unset($request[$prefix.'-l']);
                }


            }

            $validated_search_parameters[$prefix.'-o'] = $request[$prefix.'-o'];
        }

        if (empty($request[$prefix.'-id']) === false){
            if(preg_match('/^[0-9\,]+$/', $request[$prefix.'-id']) > 0){ // search by OR, marked by ","
                $ids = explode(',', $request[$prefix.'-id']);
                $conditions[] = Pressmind\Search\Condition\MediaObjectID::create($ids);
                $validated_search_parameters[$prefix.'-id'] = implode(',', $ids);

            }
        }

        if (empty($request[$prefix.'-po']) === false){
            if(preg_match('/^[0-9\,]+$/', $request[$prefix.'-po']) > 0){ // search by OR, marked by ","
                $pools = explode(',', $request[$prefix.'-po']);
                $conditions[] = Pressmind\Search\Condition\Pool::create($pools);
                $validated_search_parameters[$prefix.'-po'] = implode(',', $pools);

            }
        }

        if (empty($request[$prefix.'-st']) === false){
            if(preg_match('/^[0-9\,]+$/', $request[$prefix.'-st']) > 0){ // search by OR, marked by ","
                $states = explode(',', $request[$prefix.'-st']);
                $conditions[] = Pressmind\Search\Condition\State::create($states);
                $validated_search_parameters[$prefix.'-st'] = implode(',', $states);

            }
        }

        if (empty($request[$prefix.'-br']) === false){
            if(preg_match('/^[0-9\,]+$/', $request[$prefix.'-br']) > 0){ // search by OR, marked by ","
                $brands = explode(',', $request[$prefix.'-br']);
                $conditions[] = Pressmind\Search\Condition\Brand::create($brands);
                $validated_search_parameters[$prefix.'-br'] = implode(',', $brands);

            }
        }

        if (empty($request[$prefix.'-tr']) === false){
            if(preg_match('/^[a-z,A-Z\,]+$/', $request[$prefix.'-tr']) > 0){ // search by OR, marked by ","
                $transport_types = explode(',', $request[$prefix.'-tr']);
                $conditions[] = Pressmind\Search\Condition\Transport::create($transport_types);
                $validated_search_parameters[$prefix.'-tr'] = implode(',', $transport_types);

            }
        }

        if (empty($request[$prefix.'-vi']) === false){
            if(preg_match('/^[0-9\,]+$/', $request[$prefix.'-vi']) > 0){ // search by OR, marked by ","
                $visibilities = explode(',', $request[$prefix.'-vi']);
                $conditions[] = Pressmind\Search\Condition\Visibility::create($visibilities);
                $validated_search_parameters[$prefix.'-vi'] = implode(',', $visibilities);

            }
        }

        // Booking State (based on date)
        if (empty($request[$prefix.'-bs']) === false){
            if(preg_match('/^[0-9\,]+$/', $request[$prefix.'-bs']) > 0){ // search by OR, marked by ","
                $booking_states = explode(',', $request[$prefix.'-bs']);
                $conditions[] = Pressmind\Search\Condition\BookingState::create($booking_states);
                $validated_search_parameters[$prefix.'-bs'] = implode(',', $booking_states);
            }
        }

        if (isset($request[$prefix.'-vr']) === true) {
            $dateRange = self::extractDaterange($request[$prefix.'-vr']);
            if($dateRange !== false){
                list($from, $to) = $dateRange;
                $conditions[] = Pressmind\Search\Condition\Validity::create($from, $to);
                $validated_search_parameters[$prefix.'-dr'] = $from->format('Y-m-d').'-'.$to->format('Y-m-d');
            }
        }

        self::$current_search_query_string = urldecode(http_build_query($validated_search_parameters));

        $Search = new Pressmind\Search($conditions, [
            'start' => 0,
            'length' => 1000
        ], $order);


        if($paginator){
            $page = 0;
            //$page_size = 10;
            if (isset($request[$prefix.'-l']) === true && preg_match('/^([0-9]+)\,([0-9]+)$/', $request[$prefix.'-l'], $m) > 0) {
                $page = intval($m[1]);
                $page_size = intval($m[2]);
            }

            $Search->setPaginator(Pressmind\Search\Paginator::create($page_size, $page));
        }
        return $Search;

    }

    public static function getCurrentQueryString($page = null, $page_size = null, $prefix = 'pm'){

        $page = empty($page) ? self::$page : $page;
        $page_size = empty($page_size) ? self::$page_size : $page_size;

        return self::$current_search_query_string.'&'.$prefix.'-l='.$page.','.$page_size;
    }


    /**
     * @param $str
     * @return DateTime[]|bool
     * @throws Exception
     */
    public static function extractDaterange($str){
        if(preg_match('/^([0-9]{4}[0-9]{2}[0-9]{2})\-([0-9]{4}[0-9]{2}[0-9 ]{2})$/', $str, $m) > 0){
            return array(new DateTime($m[1]), new DateTime($m[2]));
        }
        return false;
    }

    /**
     * @param $str
     * @return int[]|bool
     */
    public static function extractDurationRange($str){
        if(preg_match('/^([0-9]+)\-([0-9]+)$/', $str, $m) > 0){
            return array($m[1], $m[2]);
        }
        return false;
    }


    /**
     * @param $str
     * @return int[]|bool
     */
    public static function extractPriceRange($str){
        if(preg_match('/^([0-9]+)\-([0-9]+)$/', $str, $m) > 0){
            return array($m[1], $m[2]);
        }
        return false;
    }



}

