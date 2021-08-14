<?php
namespace Pressmind\Travelshop;

class IB3Tools{

    /**
     * Build the booking linked based on several parameters
     * @param int $id_media_object
     * @param int $id_booking_package
     * @param int $id_date
     * @param int $id_housing_package
     * @param int $id_housing_option
     * @param string $url for history back link
     * @param string $dc discount code
     * @return string
     */
   public static function get_bookinglink($id_media_object, $id_booking_package, $id_date, $id_housing_package = null, $id_housing_option = null, $url = null, $dc = null): string
   {

       $p = [];
       $p[] = 'imo='.$id_media_object;
       $p[] = 'idbp='.$id_booking_package;
       $p[] = 'idd='.$id_date;
       if(!is_null($id_housing_package)){
           $p[] = 'idhp='.$id_housing_package;
       }
       // @TODO: possible improvement: set more than one housing_options here (with there amount)
       if(!is_null($id_housing_option)) {
           $p[] = 'iho[' . $id_housing_option . ']=1';
       }

       if(!is_null($url)){
           $p[] = 'url='.base64_encode($url);
       }

       if(!is_null($dc)){
           $p[] = 'dc='.$dc;
       }

       return TS_IBE3_BASE_URL.'?'.implode('&', $p);

   }

}
