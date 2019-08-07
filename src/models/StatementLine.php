<?php

namespace AndrewSvirin\MT942\models;

use AndrewSvirin\MT942\contracts\MarkInterface;
use DateTime;

/**
 * Statement Line specifies main information for Statement.
 *
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @author Andrew Svirin
 */
class StatementLine implements MarkInterface
{

   /**
    * @var DateTime
    */
   private $valueDate;

   /**
    * @var string MMDD
    */
   private $entryDate;

   /**
    * @var string
    */
   private $mark;

   /**
    * @var string
    */
   private $fundsCode;

   /**
    * @var float
    */
   private $amount;

   /**
    * @var string
    */
   private $transactionTypeIdCode;

   /**
    * @var string
    */
   private $customerRef;

   /**
    * @return DateTime
    */
   public function getValueDate(): DateTime
   {
      return $this->valueDate;
   }

   /**
    * @param DateTime $valueDate
    */
   public function setValueDate(DateTime $valueDate)
   {
      $this->valueDate = $valueDate;
   }

   /**
    * @return string
    */
   public function getEntryDate(): string
   {
      return $this->entryDate;
   }

   /**
    * @param string $entryDate
    */
   public function setEntryDate(string $entryDate = null)
   {
      $this->entryDate = $entryDate;
   }

   /**
    * @return string
    */
   public function getMark(): string
   {
      return $this->mark;
   }

   /**
    * @param string $mark
    */
   public function setMark(string $mark)
   {
      $this->mark = $mark;
   }

   /**
    * @return string
    */
   public function getFundsCode(): string
   {
      return $this->fundsCode;
   }

   /**
    * @param string $fundsCode
    */
   public function setFundsCode(string $fundsCode)
   {
      $this->fundsCode = $fundsCode;
   }

   /**
    * @return float
    */
   public function getAmount(): float
   {
      return $this->amount;
   }

   /**
    * @param float $amount
    */
   public function setAmount(float $amount)
   {
      $this->amount = $amount;
   }

   /**
    * @return string
    */
   public function getTransactionTypeIdCode(): string
   {
      return $this->transactionTypeIdCode;
   }

   /**
    * @param string $transactionTypeIdCode
    */
   public function setTransactionTypeIdCode(string $transactionTypeIdCode)
   {
      $this->transactionTypeIdCode = $transactionTypeIdCode;
   }

   /**
    * @return string
    */
   public function getCustomerRef(): string
   {
      return $this->customerRef;
   }

   /**
    * @param string $customerRef
    */
   public function setCustomerRef(string $customerRef)
   {
      $this->customerRef = $customerRef;
   }

}
