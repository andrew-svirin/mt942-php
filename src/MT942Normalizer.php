<?php

namespace AndriySvirin\MT942;

use AndriySvirin\MT942\models\AccountIdentification;
use AndriySvirin\MT942\models\FloorLimitIndicator;
use AndriySvirin\MT942\models\StatementNumber;
use AndriySvirin\MT942\models\Summary;
use AndriySvirin\MT942\models\Transaction;
use DateTime;

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
   const TRANSACTION_CODE_DATETIME_INDICATOR = '13';
   const TRANSACTION_CODE_SUMMARY_DEBIT = '90D';
   const TRANSACTION_CODE_SUMMARY_CREDIT = '90C';

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
    * Normalize string with list of Transactions from string.
    * @param string $str Encoded entity.
    * @return Transaction[]
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
    * Normalize transaction AccountIdentification from string.
    * @param string $str Encoded entity.
    * @return AccountIdentification
    */
   private function normalizeAccountIdentification(string $str): AccountIdentification
   {
      preg_match_all('/(?<bic>[0-9A-Z]*)\/(?<acc_nr>[0-9A-Z]*)/s', $str, $details, PREG_SET_ORDER);
      $result = new AccountIdentification();
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
    * Normalize transaction StatementNumber from string.
    * @param string $str Encoded entity.
    * @return StatementNumber
    */
   private function normalizeStatementNr(string $str): StatementNumber
   {
      preg_match_all('/(?<statement_nr>[0-9A-Z]*)\/(?<sequence_nr>[0-9A-Z]*)/s', $str, $details, PREG_SET_ORDER);
      $result = new StatementNumber();
      $result->setStatementNr($details[0]['statement_nr']);
      $result->setSequenceNr($details[0]['sequence_nr']);
      return $result;
   }

   /**
    * Normalize transaction FloorLimitIndicator from string.
    * @param string $str Encoded entity.
    * @return FloorLimitIndicator
    */
   private function normalizeFloorLimitIndicator(string $str): FloorLimitIndicator
   {
      preg_match_all('/(?<currency>[A-Z]{3})(?<type>[A-Z]{0,1})(?<amount>[0-9,]*)/s', $str, $details, PREG_SET_ORDER);
      $result = new FloorLimitIndicator();
      $result->setType(!empty($details[0]['type']) ? $details[0]['type'] : null);
      $money = $result->getMoney();
      $money->setCurrency($details[0]['currency']);
      $money->setAmount((float)$details[0]['amount']);
      return $result;
   }

   /**
    * Normalize transaction DateTime from string.
    * @param string $str Encoded entity.
    * @return DateTime
    */
   private function normalizeDatetimeIndicator(string $str): DateTime
   {
      $result = DateTime::createFromFormat('ymdHi', $str);
      return $result;
   }

   /**
    * Normalize transaction Debit or Credit Summary from string.
    * @param string $str Encoded entity.
    * @return Summary
    */
   private function normalizeSummary(string $str): Summary
   {
      preg_match_all('/(?<entries_nr>[0-9]{1,5})(?<currency>[A-Z]{3})(?<amount>[0-9,]*)/s', $str, $details, PREG_SET_ORDER);
      $result = new Summary();
      $result->setEntriesNr($details[0]['entries_nr']);
      $money = $result->getMoney();
      $money->setCurrency($details[0]['currency']);
      $money->setAmount((float)$details[0]['amount']);
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
            case self::TRANSACTION_CODE_DATETIME_INDICATOR:
               $transaction->setDatetimeIndicator($this->normalizeDatetimeIndicator($transactionDetail['message']));
               break;
            case self::TRANSACTION_CODE_SUMMARY_DEBIT:
               $transaction->setSummaryDebit($this->normalizeSummary($transactionDetail['message']));
               break;
            case self::TRANSACTION_CODE_SUMMARY_CREDIT:
               $transaction->setSummaryCredit($this->normalizeSummary($transactionDetail['message']));
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
