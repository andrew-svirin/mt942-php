<?php

namespace AndriySvirin\MT942\models;

/**
 * Payment class.
 */
class Payment
{

   /**
    * Transaction Reference Number
    * @var string
    */
   public $trn;

   /**
    * Account identification.
    * @var string
    */
   public $accountId;

   /**
    * Sequence number
    * @var string
    */
   public $sequenceNum;

   /**
    * Floor limit indicator credit
    * @var string
    */
   public $flIndicator;

   /**
    * Date/time indicator
    * @var string
    */
   public $dtIndicator;

   /**
    * Numbers and sum of debit entries
    * @var string
    */
   public $debit;

   /**
    * Numbers and sum of credit entries
    * @var string
    */
   public $credit;

   /**
    * Statements.
    * @var Statement[]
    */
   public $statements = [];

   /**
    * Convert from string.
    * @param string $str
    * @return Payment
    */
   public static function fromString($str)
   {
      $mt942Payment = new Payment();
      $rows = preg_split('/[\r|\n|\r\n](:.*[^\?])/', $str, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
      $stLine = [];
      $stDesc = [];
      foreach ($rows as $row)
      {
         $rowData = preg_split('/^:([^:]+):(((.*),$)|((.*),\n+$)|((.*)\n+$)|(.*$))/s', $row, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
         $key = $rowData[0];
         $value = rtrim(trim($rowData[1]), ',');
         switch ($key)
         {
            case '20': // Transaction Reference Number
               $mt942Payment->trn = $value;
               break;
            case '25': // Account Identification
               $mt942Payment->accountId = $value;
               break;
            case '28C': // Statement Number/Sequence Number
               $mt942Payment->sequenceNum = $value;
               break;
            case '34F': // Floor Limit Indicator (First Occurrence)  TODO: Floor Limit Indicator (Second Occurrence)
               $mt942Payment->flIndicator = $value;
               break;
            case '13': // Date/time Indication TODO: Could be 13D
               $dateTime = preg_split('/^(.{2})(.{2})(.{2})(.{2})(.{2})$/s', $value, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
               $mt942Payment->dtIndicator = "20{$dateTime[0]}-{$dateTime[1]}-{$dateTime[2]} {$dateTime[3]}:{$dateTime[4]}";
               break;
            case '61': // Statement Line TODO: Optional TODO: List of codes TODO: customerReference
               $stLine[] = $value;
               break;
            case '86': // Information to Account Owner TODO: Optional
               $stDesc[] = $value;
               break;
            case '90D': // Number and Sum of Entries
               $mt942Payment->debit = $value;
               break;
            case '90C': // Number and Sum of Entries
               $mt942Payment->credit = $value;
               break;
         }
      }
      foreach ($stLine as $i => $sl)
      {
         $mt942Payment->statements[] = Statement::fromString($sl, $stDesc[$i]);
      }

      return $mt942Payment;
   }

}
