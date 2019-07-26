<?php

namespace AndriySvirin\MT942\models;

use DateTime;

/**
 * Transaction class used for list of main entities.
 */
class Transaction
{

   /**
    * Transaction Reference Number.
    * This field specifies the reference assigned byt the Sender to unambiguously identify the message.
    * @var string
    */
   private $trnRefNr;

   /**
    * Account Identification.
    * This field identifies the account for which the statement is sent.
    * @var AccountIdentification
    */
   private $accId;

   /**
    * Statement Number.
    * This field contains the sequential number of the statement, optionally followed by the sequence number of
    * the message within that statement when more than one message is sent for one statement.
    * @var StatementNumber
    */
   private $statementNr;

   /**
    * Floor Limit Indicator.
    * This field specifies the minimum value an order must have to be individually delivered.
    * @var FloorLimitIndicator
    */
   private $floorLimitIndicator;

   /**
    * Date & time indicator
    * @var DateTime
    */
   private $datetimeIndicator;

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
   public function getTrnRefNr()
   {
      return $this->trnRefNr;
   }

   /**
    * @param string $value
    */
   public function setTrnRefNr($value)
   {
      $this->trnRefNr = $value;
   }

   /**
    * @return AccountIdentification
    */
   public function getAccId()
   {
      return $this->accId;
   }

   /**
    * @param AccountIdentification $value
    */
   public function setAccId(AccountIdentification $value)
   {
      $this->accId = $value;
   }

   /**
    * @return StatementNumber
    */
   public function getStatementNr(): StatementNumber
   {
      return $this->statementNr;
   }

   /**
    * @param StatementNumber $value
    */
   public function setStatementNr(StatementNumber $value)
   {
      $this->statementNr = $value;
   }
   /**
    * @param FloorLimitIndicator $value
    */
   public function setFloorLimitIndicator(FloorLimitIndicator $value)
   {
      $this->floorLimitIndicator = $value;
   }

   /**
    * @return DateTime
    */
   public function getDatetimeIndicator(): DateTime
   {
      return $this->datetimeIndicator;
   }

   /**
    * @param DateTime $datetimeIndicator
    */
   public function setDatetimeIndicator(DateTime $datetimeIndicator)
   {
      $this->datetimeIndicator = $datetimeIndicator;
   }

}
