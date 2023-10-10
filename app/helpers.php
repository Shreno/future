<?php


  

   /* ---------------------- start qr methods ----------------- */
   function __getLength($value)
   {
       return strlen($value);
   }

   function __toHex($value)
   {
       return pack("H*", sprintf("%02X", $value));
   }

   function __toString($__tag, $__value, $__length)
   {
       $value = (string) $__value;
       return __toHex($__tag) . __toHex($__length) . $value;
   }

   function __getTLV($dataToEncode)
   {
       $__TLVS = '';
       for ($i = 0; $i < count($dataToEncode); $i++) {
           $__tag = $dataToEncode[$i][0];
           $__value = $dataToEncode[$i][1];
           $__length = __getLength($__value);
           $__TLVS .= __toString($__tag, $__value, $__length);
       }

       return $__TLVS;
   }
   /*----------------------- end qr methods -------------------*/

function customRequestCaptcha(){
    return new \ReCaptcha\RequestMethod\Post();
}
