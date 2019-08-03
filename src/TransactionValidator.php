<?php

namespace AndrewSvirin\MT942;

use AndrewSvirin\MT942\models\Transaction;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Validator class for @see Transaction and related models.
 *
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @author Andrew Svirin
 */
class TransactionValidator
{

   /**
    * Validation rules for @see Transaction
    * @param ClassMetadata $metadata
    */
   public static function loadTransactionValidatorMetadata(ClassMetadata $metadata)
   {
      // Must have a trnRefNr.
      $metadata->addPropertyConstraint('trnRefNr', new NotBlank());
   }

}