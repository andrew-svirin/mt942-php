<?php

namespace AndriySvirin\MT942\models;

/**
 * Statement information specifies multiple additional options for statement for account owner purpose.
 */
class StatementInformation
{

   /**
    * Lines of the information.
    * @var array
    */
   private $informationLines = [];

   /**
    * @return array
    */
   public function getInformationLines(): array
   {
      return $this->informationLines;
   }

   /**
    * @param string $nr
    * @param string $line
    */
   public function addLine(string $nr, string $line)
   {
      $this->informationLines[$nr] = $line;
   }

}
