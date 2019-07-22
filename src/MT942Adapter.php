<?php

namespace AndriySvirin\MT942;

use AndriySvirin\MT942\models\Transaction;

/**
 * Main MT942 parser class.
 */
final class MT942Adapter
{

   /**
    * Transaction Reference Number
    */
   const TRANSACTION_TRN = '20';

   /**
    * Default delimiter.
    */
   const DEFAULT_DELIMITER = "\r\n-\r\n";

   /**
    * Delimiter that slice string on transactions pieces.
    * @var string
    */
   private $delimiter;

   public function __construct($delimiter = null)
   {
      $this->delimiter = null !== $delimiter ? (string)$delimiter : self::DEFAULT_DELIMITER;
   }

   /**
    * @param string $delimiter
    */
   public function setDelimiter($delimiter)
   {
      $this->delimiter = $delimiter;
   }

   /**
    * Decode string with transactions.
    * @param string $str
    * @return Transaction[]
    */
   public function decode($str)
   {
      $records = explode($this->delimiter, $str);
      $transactions = [];
      foreach ($records as $record)
      {
         $transactions[] = $this->decodeRecord($record);
      }
      return $transactions;
   }

   /**
    * @param string $record
    * @return Transaction
    */
   private function decodeRecord($record)
   {
      $transaction = new Transaction();
      // TODO: Slice on arrays.
      $rows = preg_match_all('/:(?!\n)([0-9A-Z]*):(((?!\n:).)*)/s', $record, $matches);
      return $transaction;
      $stLine = [];
      $stDesc = [];
      foreach ($rows as $row)
      {
         $rowData = preg_split('/^:([^:]+):(((.*),$)|((.*),\n+$)|((.*)\n+$)|(.*$))/s', $row, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
         $key = $rowData[0];
         $value = rtrim(trim($rowData[1]), ',');
         switch ($key)
         {
            case self::TRANSACTION_TRN:
               $transaction->trn = $value;
               break;
            case '25': // Account Identification
               $transaction->accountId = $value;
               break;
            case '28C': // Statement Number/Sequence Number
               $transaction->sequenceNum = $value;
               break;
            case '34F': // Floor Limit Indicator (First Occurrence)  TODO: Floor Limit Indicator (Second Occurrence)
               $transaction->flIndicator = $value;
               break;
            case '13': // Date/time Indication TODO: Could be 13D
               $dateTime = preg_split('/^(.{2})(.{2})(.{2})(.{2})(.{2})$/s', $value, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
               $transaction->dtIndicator = "20{$dateTime[0]}-{$dateTime[1]}-{$dateTime[2]} {$dateTime[3]}:{$dateTime[4]}";
               break;
            case '61': // Statement Line TODO: Optional TODO: List of codes TODO: customerReference
               $stLine[] = $value;
               break;
            case '86': // Information to Account Owner TODO: Optional
               $stDesc[] = $value;
               break;
            case '90D': // Number and Sum of Entries
               $transaction->debit = $value;
               break;
            case '90C': // Number and Sum of Entries
               $transaction->credit = $value;
               break;
         }
      }
      foreach ($stLine as $i => $sl)
      {
//         $transaction->statements[] = Statement::fromString($sl, $stDesc[$i]);
      }

      return $transaction;
   }

}
