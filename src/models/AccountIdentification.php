<?php

namespace AndriySvirin\MT942\models;

/**
 * Account Identification. Can have one of format.
 */
class AccountIdentification
{

   const TYPE_A = 'A';
   const TYPE_B = 'B';

   private $IBAN;

   /**
    * Statement Number.
    * The statement number should be reset to 1 in beginning of every day.
    * @var string
    */
   private $BIC;

   /**
    * Sequence Number.
    * The sequence number always starts with 001. When several messages are sent to convey information about
    * a single statement, the first message must contain '/001' in Sequence Number.
    * One SWIFT message may contain up to 2000 characters.
    * The sequence number must be incremented by one for each additional message.
    * @var
    */
   private $AccNr;

}