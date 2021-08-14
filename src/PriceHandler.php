<?php

namespace Pressmind\Travelshop;

use Pressmind\ORM\Object\CheapestPriceSpeed;

final class PriceHandler
{

    /**
     * Normalizes different offer types
     * @param CheapestPriceSpeed $cheapest_price
     * @return false|array{price_total: string ,price_before_discount: string, price_delta: string, valid_to: \DateTime, type: string}
     */
    public static function getDiscount($cheapest_price, $earlybird_name = 'Frühbucher', $pseudo_price_name = 'Ihr Vorteil'){

        $output = [];

        // detect valid earlybird discount
        if(!empty($cheapest_price->earlybird_discount)){
            // is earlybird
            $output['price_before_discount'] = self::format($cheapest_price->price_regular_before_discount);
            $output['price_delta'] = '-'.$cheapest_price->earlybird_discount.'%';
            $output['valid_to'] = $cheapest_price->earlybird_discount_date_to;
            $output['name'] = $earlybird_name;
            $output['type'] = 'earlybird';
            return $output;
        }

        if(!empty($cheapest_price->earlybird_discount_f)){
            // is earlybird with a fixed price
            $output['price_before_discount'] = self::format($cheapest_price->price_regular_before_discount);
            $output['price_delta'] = '-'.self::format($cheapest_price->earlybird_discount_f);
            $output['valid_to'] = $cheapest_price->earlybird_discount_date_to;
            $output['name'] = $earlybird_name;
            $output['type'] = 'earlybird';
            return $output;
        }


        if (!empty($cheapest_price->price_option_pseudo) &&
            $cheapest_price->price_option_pseudo > $cheapest_price->price_total) {

            // is a pseudo price offer
            $percent_discount = round((100 / $cheapest_price->price_option_pseudo) * ($cheapest_price->price_option_pseudo - $cheapest_price->price_total));
            $output['price_before_discount'] = self::format($cheapest_price->price_option_pseudo);
            $output['price_delta'] = '-'.$percent_discount.'%';
            $output['valid_to'] = null;
            $output['name'] = $pseudo_price_name;
            $output['type'] = 'pseudo';
            return $output;
        }

        return false;

    }

    /**
     * @param float $price
     * @return string
     */
    public static function format($price){

        $price = number_format($price, TS_PRICE_DECIMALS, TS_PRICE_DECIMAL_SEPARATOR, TS_PRICE_THOUSANDS_SEPARATOR);

        if(TS_PRICE_CURRENCY_POSITION == 'LEFT'){
            return TS_PRICE_CURRENCY.'&nbsp;'.$price;
        }

        return $price.'&nbsp;'.TS_PRICE_CURRENCY;
    }

}