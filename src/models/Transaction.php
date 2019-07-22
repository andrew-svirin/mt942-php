<?php

namespace AndriySvirin\MT942\models;

/**
 * Transaction class used for list of main entities.
 */
class Transaction
{

   /**
    * Transaction Reference Number.
    * @var string
    */
   private $trnRefNum;

   /**
    * Related reference.
    * @var string
    */
   private $relRef;

   /**
    * Account identification.
    * @var string
    */
   private $accountId;

   /**
    * Sequence number
    * @var string
    */
   private $sequenceNum;

   /**
    * Floor limit indicator credit
    * @var string
    */
   private $flIndicator;

   /**
    * Date/time indicator
    * @var string
    */
   private $dtIndicator;

   /**
    * Numbers and sum of debit entries
    * @var string
    */
   private $debit;

   /**
    * Numbers and sum of credit entries
    * @var string
    */
   private $credit;

   /**
    * Statements.
    * @var Statement[]
    */
   private $statements = [];

   /**
    * @return string
    */
   public function getTrnRefNum()
   {
      return $this->trnRefNum;
   }

   /**
    * @param string $value
    */
   public function setTrnRefNum($value)
   {
      $this->trnRefNum = $value;
   }

}
