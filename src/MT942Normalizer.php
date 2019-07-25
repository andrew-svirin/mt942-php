<?php

namespace AndriySvirin\MT942;

use AndriySvirin\MT942\models\AccountIdentification;
use AndriySvirin\MT942\models\FloorLimitIndicator;
use AndriySvirin\MT942\models\StatementNumber;
use AndriySvirin\MT942\models\Transaction;

/**
 * Main MT942 parser class.
 */
final class MT942Normalizer
{

   /**
    * Transaction codes.
    */
   const TRANSACTION_CODE_TRN_REF_NR = '20';
   const TRANSACTION_CODE_ACCOUNT_ID = '25';
   const TRANSACTION_CODE_STATEMENT_NR = '28C';
   const TRANSACTION_CODE_FLOOR_LIMIT_INDICATOR = '34F';

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
    * Normalize string with list of @param string $str Encoded entity.
    * @return Transaction[]
    * @see Transaction.
    */
   public function normalize($str)
   {
      $records = explode($this->delimiter, $str);
      $result = [];
      foreach ($records as $record)
      {
         $result[] = $this->normalizeTransaction($record);
      }
      return $result;
   }

   /**
    * Normalize transaction @param string $str Encoded entity.
    * @return AccountIdentification
    * @see AccountIdentification from string.
    */
   private function normalizeAccountIdentification(string $str): AccountIdentification
   {
      $result = new AccountIdentification();
      preg_match_all('/(?<bic>[0-9A-Z]*)\/(?<acc_nr>[0-9A-Z]*)/s', $str, $details, PREG_SET_ORDER);
      if (!empty($details[0]['bic']) && !empty($details[0]['acc_nr']))
      {
         $result->setTypeA();
         $result->setBIC($details[0]['bic']);
         $result->setAccNr($details[0]['acc_nr']);
      }
      else
      {
         preg_match_all('/(?<country_code>[0-9A-Z]{2})(?<control_code>[0-9A-Z]{2})(?<bban>[0-9A-Z]*)/s', $str, $details, PREG_SET_ORDER);
         $result->setTypeB();
         $result->setIBANCountryCode($details[0]['country_code']);
         $result->setIBANControlCode($details[0]['control_code']);
         $result->setIBANBBAN($details[0]['bban']);
      }
      return $result;
   }

   /**
    * Normalize transaction @param string $str Encoded entity.
    * @return StatementNumber
    * @see StatementNumber from string.
    */
   private function normalizeStatementNr(string $str): StatementNumber
   {
      $result = new StatementNumber();
      preg_match_all('/(?<statement_nr>[0-9A-Z]*)\/(?<sequence_nr>[0-9A-Z]*)/s', $str, $details, PREG_SET_ORDER);
      $result->setStatementNr($details[0]['statement_nr']);
      $result->setSequenceNr($details[0]['sequence_nr']);
      return $result;
   }

   /**
    * Normalize transaction @param string $str
    * @return FloorLimitIndicator
    * @see FloorLimitIndicator from string.
    */
   private function normalizeFloorLimitIndicator(string $str): FloorLimitIndicator
   {
      $result = new FloorLimitIndicator();
      preg_match_all('/(?<currency>[A-Z]{3})(?<type>[A-Z]{0,1})(?<amount>[0-9,]*)/s', $str, $details, PREG_SET_ORDER);
      $result->setCurrency($details[0]['currency']);
      $result->setType(!empty($details[0]['type']) ? $details[0]['type'] : null);
      $result->setAmount((float)$details[0]['amount']);
      return $result;
   }

   /**
    * @param string $str
    *   Contains encoded information about transactions.
    * @return Transaction
    */
   private function normalizeTransaction(string $str)
   {
      // Extract from record pairs code and message, all other keys are overhead.
      preg_match_all('/:(?!\n)(?<code>[0-9A-Z]*):(?<message>((?!\r\n:).)*)/s', $str, $transactionDetails, PREG_SET_ORDER);
      $transaction = new Transaction();
      foreach ($transactionDetails as $transactionDetail)
      {
         switch ($transactionDetail['code'])
         {
            case self::TRANSACTION_CODE_TRN_REF_NR:
               $transaction->setTrnRefNr($transactionDetail['message']);
               break;
            case self::TRANSACTION_CODE_ACCOUNT_ID:
               $transaction->setAccId($this->normalizeAccountIdentification($transactionDetail['message']));
               break;
            case self::TRANSACTION_CODE_STATEMENT_NR:
               $transaction->setStatementNr($this->normalizeStatementNr($transactionDetail['message']));
               break;
            case self::TRANSACTION_CODE_FLOOR_LIMIT_INDICATOR:
               $transaction->setFloorLimitIndicator($this->normalizeFloorLimitIndicator($transactionDetail['message']));
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
            case self::TRANSACTION_CODE_TRN_REF_NR:
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
