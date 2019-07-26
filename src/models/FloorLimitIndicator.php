<?php

namespace AndriySvirin\MT942\models;

/**
 * Floor Limit Indicator specifies the amount of money.
 */
class FloorLimitIndicator
{

   /**
    * Debit or Credit mark.
    *
    * @var string [D|C]
    */
   private $type;

   /**
    * @var Money
    */
   private $money;

   public function __construct()
   {
      $this->money = new Money();
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
    * @return Money
    */
   public function getMoney(): Money
   {
      return $this->money;
   }

}