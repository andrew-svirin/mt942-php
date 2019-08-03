<?php

namespace AndrewSvirin\MT942\models;

/**
 * Statement specifies information about transaction operation.
 *
 * @author Andrew Svirin
 */
class Statement
{

   /**
    * @var StatementLine
    */
   private $line;

   /**
    * @var StatementInformation
    */
   private $information;

   /**
    * @return StatementLine
    */
   public function getLine(): StatementLine
   {
      return $this->line;
   }

   /**
    * @param StatementLine $value
    */
   public function setLine(StatementLine $value)
   {
      $this->line = $value;
   }

   /**
    * @return null|StatementInformation
    */
   public function getInformation()
   {
      return $this->information;
   }

   /**
    * @param StatementInformation $value
    */
   public function setInformation(StatementInformation $value)
   {
      $this->information = $value;
   }

}
