<?php

namespace AndriySvirin;

use AndriySvirin\MT942\MT942Payment;

/**
 * Main MT942 parser class.
 */
class MT942
{

   /**
    * Payments
    * @var MT942Payment[]
    */
   public $payments = [];

   /**
    * Convert from string.
    * @param string $str
    * @return MT942
    */
   public static function fromString($str)
   {
      $mt942 = new MT942();
      $rows = preg_split("/(\r\n|\n|\r)-(\r\n|\n|\r)/", trim($str));
      foreach ($rows as $row)
      {
         $mt942->payments[] = MT942Payment::fromString($row);
      }

      return $mt942;
   }

}
