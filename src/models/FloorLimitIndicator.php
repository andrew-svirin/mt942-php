<?php

namespace AndrewSvirin\MT942\models;

/**
 * Floor Limit Indicator specifies the amount of money.
 *
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @author Andrew Svirin
 */
class FloorLimitIndicator
{

   /**
    * Debit or Credit mark.
    *
    * @var string [D|C]
    */
   private $dcMark;

   /**
    * @var Money
    */
   private $money;

   public function __construct()
   {
      $this->money = new Money();
   }

   /**
    * @return null|string
    */
   public function getDCMark()
   {
      return $this->dcMark;
   }

   /**
    * @param string $value
    */
   public function setDCMark(string $value = null)
   {
      $this->dcMark = $value;
   }

   /**
    * @return Money
    */
   public function getMoney(): Money
   {
      return $this->money;
   }

}