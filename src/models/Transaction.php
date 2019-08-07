<?php

namespace AndrewSvirin\MT942\models;

use DateTime;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Transaction class used for handle main entity properties.
 *
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @author Andrew Svirin
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
   private $accountIdentification;

   /**
    * Statement Number.
    * This field contains the sequential number of the statement, optionally followed by the sequence number of
    * the message within that statement when more than one message is sent for one statement.
    * @var StatementNumber
    */
   private $statementNumber;

   /**
    * Floor Limit Indicator.
    * This field specifies the minimum value an order must have to be individually delivered.
    * @var FloorLimitIndicator
    */
   private $floorLimitIndicator;

   /**
    * Floor Limit Indicator for Credit.
    * This field specifies the minimum value an order must have to be individually delivered, but specifically for
    * credit messages.
    * @var FloorLimitIndicator
    */
   private $creditFloorLimitIndicator;

   /**
    * Date & time indicator
    * @var DateTime
    */
   private $datetimeIndicator;

   /**
    * Numbers and sum of debit entries.
    * @var Summary
    */
   private $summaryDebit;

   /**
    * Numbers and sum of credit entries.
    * @var Summary
    */
   private $summaryCredit;

   /**
    * Statements for transaction can hold multiple operations.
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
   public function getAccountIdentification()
   {
      return $this->accountIdentification;
   }

   /**
    * @param AccountIdentification $value
    */
   public function setAccountIdentification(AccountIdentification $value)
   {
      $this->accountIdentification = $value;
   }

   /**
    * @return StatementNumber
    */
   public function getStatementNumber(): StatementNumber
   {
      return $this->statementNumber;
   }

   /**
    * @param StatementNumber $value
    */
   public function setStatementNumber(StatementNumber $value)
   {
      $this->statementNumber = $value;
   }

   /**
    * @return null|FloorLimitIndicator
    */
   public function getFloorLimitIndicator()
   {
      return $this->floorLimitIndicator;
   }

   /**
    * @param FloorLimitIndicator $value
    */
   public function setFloorLimitIndicator(FloorLimitIndicator $value)
   {
      $this->floorLimitIndicator = $value;
   }

   /**
    * @return null|FloorLimitIndicator
    */
   public function getCreditFloorLimitIndicator()
   {
      return $this->creditFloorLimitIndicator;
   }

   /**
    * @param FloorLimitIndicator $creditFloorLimitIndicator
    */
   public function setCreditFloorLimitIndicator(FloorLimitIndicator $creditFloorLimitIndicator)
   {
      $this->creditFloorLimitIndicator = $creditFloorLimitIndicator;
   }

   /**
    * @return DateTime
    */
   public function getDatetimeIndicator(): DateTime
   {
      return $this->datetimeIndicator;
   }

   /**
    * @param DateTime $value
    */
   public function setDatetimeIndicator(DateTime $value)
   {
      $this->datetimeIndicator = $value;
   }

   /**
    * @return Statement[]
    */
   public function getStatements(): array
   {
      return $this->statements;
   }

   /**
    * @param Statement $statement
    */
   public function addStatement(Statement $statement)
   {
      $this->statements[] = $statement;
   }

   /**
    * @return null|Summary
    */
   public function getSummaryDebit()
   {
      return $this->summaryDebit;
   }

   /**
    * @param Summary $value
    */
   public function setSummaryDebit(Summary $value)
   {
      $this->summaryDebit = $value;
   }

   /**
    * @return null|Summary
    */
   public function getSummaryCredit()
   {
      return $this->summaryCredit;
   }

   /**
    * @param Summary $value
    */
   public function setSummaryCredit(Summary $value)
   {
      $this->summaryCredit = $value;
   }

   /**
    * Validation rules.
    * @param ClassMetadata $metadata
    * @see MT942Validator::getValidator()
    */
   public static function loadValidatorMetadata(ClassMetadata $metadata)
   {
      // Must have a trnRefNr. Max length is 16 characters. Pattern - word.
      $metadata
         ->addPropertyConstraints('trnRefNr', [
            new NotBlank(),
            new Length(['max' => 16]),
            new Regex(['pattern' => '/^\w+$/']),
         ]);
      // Must have a accountIdentification.
      $metadata->addPropertyConstraint('accountIdentification', new NotBlank());
      // Must have a statementNumber.
      $metadata->addPropertyConstraint('statementNumber', new NotBlank());
      // Must have a floorLimitIndicator.
      $metadata->addPropertyConstraint('floorLimitIndicator', new NotBlank());
      // Must have a datetimeIndicator.
      $metadata->addPropertyConstraint('datetimeIndicator', new NotBlank());
   }
}
