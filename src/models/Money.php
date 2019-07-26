<?php

namespace AndriySvirin\MT942\models;

/**
 * Money specifies currency and amount.
 */
class Money
{

   /**
    * Currency ISO code.
    *
    * @var string
    */
   private $currency;

   /**
    * Amount.
    *
    * @var float
    */
   private $amount;

   /**
    * @return string
    */
   public function getCurrency(): string
   {
      return $this->currency;
   }

   /**
    * @param string $value
    */
   public function setCurrency(string $value)
   {
      $this->currency = $value;
   }

   /**
    * @return float
    */
   public function getAmount(): float
   {
      return $this->amount;
   }

   /**
    * @param float $value
    */
   public function setAmount(float $value)
   {
      $this->amount = $value;
   }

}