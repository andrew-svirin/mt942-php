<?php

namespace AndrewSvirin\MT942\models;

/**
 * Summary for transaction operations.
 *
 * @author Andrew Svirin
 */
class Summary
{

   /**
    * Number of entries.
    *
    * @var int
    */
   private $entriesNr;

   /**
    * Sum of entries.
    * @var Money
    */
   private $money;

   public function __construct()
   {
      $this->money = new Money();
   }

   /**
    * @return int
    */
   public function getEntriesNr(): int
   {
      return $this->entriesNr;
   }

   /**
    * @param int $value
    */
   public function setEntriesNr(int $value)
   {
      $this->entriesNr = $value;
   }

   /**
    * @return Money
    */
   public function getMoney(): Money
   {
      return $this->money;
   }

   /**
    * @param Money $value
    */
   public function setMoney(Money $value)
   {
      $this->money = $value;
   }

}