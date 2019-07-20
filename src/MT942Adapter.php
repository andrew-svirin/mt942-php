<?php

namespace AndriySvirin\MT942;

use AndriySvirin\MT942\models\Payment;

/**
 * Main MT942 parser class.
 */
class MT942Adapter
{

   /**
    * Convert from string.
    * @param string $str
    * @return Payment[]
    */
   public function decode($str)
   {
      $rows = preg_split("/(\r\n|\n|\r)-(\r\n|\n|\r)/", trim($str));
      $payments = [];
      foreach ($rows as $row)
      {
         $payments[] = Payment::fromString($row);
      }

      return $payments;
   }

}
