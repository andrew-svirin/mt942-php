<?php

namespace AndriySvirin\MT942\models;

/**
 * Statement information specifies multiple additional options for statement for account owner purpose.
 */
class StatementInformation
{

   const LINE_DESCRIPTION = '00';

   /**
    * Identification code.
    * Business Transaction code.
    * @var string
    */
   private $idCode;

   /**
    * Lines of the information.
    * @var array
    */
   private $lines = [];

   /**
    * @return array
    */
   public function getLines(): array
   {
      return $this->lines;
   }

   /**
    * @param string $nr
    * @param string $line
    */
   public function addLine(string $nr, string $line)
   {
      $this->lines[$nr] = $line;
   }

   /**
    * @return string
    */
   public function getIdCode(): string
   {
      return $this->idCode;
   }

   /**
    * @param string $idCode
    */
   public function setIdCode(string $idCode)
   {
      $this->idCode = $idCode;
   }

   /**
    * Booking text.
    * Transaction Description – Payment Origin (according to transaction code).
    * @return string
    */
   public function getDescription()
   {
      return $this->lines[self::LINE_DESCRIPTION] ?? null;
   }

}
