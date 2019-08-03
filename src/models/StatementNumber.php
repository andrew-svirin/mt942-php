<?php

namespace AndrewSvirin\MT942\models;

/**
 * Statement Number specifies transaction operation numeration.
 *
 * @author Andrew Svirin
 */
class StatementNumber
{

   /**
    * Statement Number.
    * The statement number should be reset to 1 in beginning of every day.
    * @var string
    */
   private $statementNr;

   /**
    * Sequence Number.
    * The sequence number always starts with 001. When several messages are sent to convey information about
    * a single statement, the first message must contain '/001' in Sequence Number.
    * One SWIFT message may contain up to 2000 characters.
    * The sequence number must be incremented by one for each additional message.
    * @var
    */
   private $sequenceNr;

   /**
    * @return string
    */
   public function getStatementNr(): string
   {
      return $this->statementNr;
   }

   /**
    * @param string $value
    */
   public function setStatementNr(string $value)
   {
      $this->statementNr = $value;
   }

   /**
    * @return mixed
    */
   public function getSequenceNr()
   {
      return $this->sequenceNr;
   }

   /**
    * @param mixed $value
    */
   public function setSequenceNr($value)
   {
      $this->sequenceNr = $value;
   }

}