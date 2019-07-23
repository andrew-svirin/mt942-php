<?php

namespace AndriySvirin\MT942;

use AndriySvirin\MT942\models\Transaction;

/**
 * Main MT942 parser class.
 */
final class MT942Normalizer
{

   /**
    * Transaction Reference Number code.
    */
   const TRANSACTION_CODE_TRN_REF_NUM = '20';

   /**
    * Account Identification code.
    */
   const TRANSACTION_CODE_ACCOUNT_ID= '25';

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
    *    Contains encoded information about transactions.
    * @return Transaction[]
    */
   public function normalize($str)
   {
      $records = explode($this->delimiter, $str);
      $transactions = [];
      foreach ($records as $record)
      {
         $transactions[] = $this->normalizeRecord($record);
      }
      return $transactions;
   }

   /**
    * @param string $record
    *   Contains encoded information about transactions.
    * @return Transaction
    */
   private function normalizeRecord($record)
   {
      // Extract from record pairs code and message, all other keys are overhead.
      preg_match_all('/:(?!\n)(?<code>[0-9A-Z]*):(?<message>((?!\r\n:).)*)/s', $record, $transactionDetails, PREG_SET_ORDER);
      $transaction = new Transaction();
      foreach ($transactionDetails as $transactionDetail)
      {
         switch ($transactionDetail['code'])
         {
            case self::TRANSACTION_CODE_TRN_REF_NUM:
               $transaction->setTrnRefNr($transactionDetail['message']);
               break;
            case self::TRANSACTION_CODE_ACCOUNT_ID:
               $transaction->setAccountId($transactionDetail['message']);
               break;
         }
      }
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
            case self::TRANSACTION_CODE_TRN_REF_NUM:
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
