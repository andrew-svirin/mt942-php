<?php

namespace AndriySvirin\MT942\models;

/**
 * Floor Limit Indicator specifies the amount of money.
 */
class FloorLimitIndicator
{

   /**
    * ISO code.
    *
    * @var string
    */
   private $currency;

   /**
    * Debit or Credit mark.
    *
    * @var string [D|C]
    */
   private $type;

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
    * @return string
    */
   public function getType(): string
   {
      return $this->type;
   }

   /**
    * @param string $value
    */
   public function setType(string $value = null)
   {
      $this->type = $value;
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