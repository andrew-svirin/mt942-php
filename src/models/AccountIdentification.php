<?php

namespace AndriySvirin\MT942\models;

/**
 * Account Identification specifies Bank Person Account.
 * Can have one of format A or B.
 * @see IBAN standard.
 */
class AccountIdentification
{

   /**
    * Types.
    */
   const TYPE_A = 'A';
   const TYPE_B = 'B';

   /**
    * Type.
    * There type A is described by IBAN & BAC.
    * There type B is described by country code & account number.
    *
    * @var string
    */
   private $type;

   /**
    * IBAN country code.
    * @var string
    */
   private $ibanCountryCode;

   /**
    * IBAN control code.
    *
    * @var string
    */
   private $ibanControlCode;
   /**
    * IBAN Basic Bank Account Number.
    *
    * @var string
    */
   private $ibanBBAN;

   /**
    * Bank Identifier Code.
    *
    * @var string
    */
   private $bic;

   /**
    * Account Number.
    *
    * @var string
    */
   private $accNr;

   public function setTypeA()
   {
      $this->type = self::TYPE_A;
   }

   public function setTypeB()
   {
      $this->type = self::TYPE_B;
   }

   /**
    * @return string
    */
   public function getIBANCountryCode(): string
   {
      return $this->ibanCountryCode;
   }

   /**
    * @param string $value
    */
   public function setIBANCountryCode(string $value)
   {
      $this->ibanCountryCode = $value;
   }

   /**
    * @return string
    */
   public function getIBANControlCode(): string
   {
      return $this->ibanControlCode;
   }

   /**
    * @param string $value
    */
   public function setIBANControlCode(string $value)
   {
      $this->ibanControlCode = $value;
   }

   /**
    * @return string
    */
   public function getIBANBBAN(): string
   {
      return $this->ibanBBAN;
   }

   /**
    * @param string $value
    */
   public function setIBANBBAN(string $value)
   {
      $this->ibanBBAN = $value;
   }

   /**
    * @return string
    */
   public function getBIC(): string
   {
      return $this->bic;
   }

   /**
    * @param string $value
    */
   public function setBIC(string $value)
   {
      $this->bic = $value;
   }

   /**
    * @return string
    */
   public function getAccNr(): string
   {
      return $this->accNr;
   }

   /**
    * @param string $value
    */
   public function setAccNr(string $value)
   {
      $this->accNr = $value;
   }

}