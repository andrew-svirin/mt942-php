<?php

namespace AndrewSvirin\tests\Unit;

use AndrewSvirin\MT942\MT942Normalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;

/**
 * Class MT942Test.
 *
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @author Andrew Svirin
 */
final class MT942Test extends TestCase
{

   var $dir = __DIR__ . '/../_data';

   public function testNormalizer()
   {
      $adapter = new MT942Normalizer();
      $str = file_get_contents($this->dir . '/transactions.mt942');
      $transactionList = $adapter->normalize($str);
      $this->assertNotEmpty($transactionList->count());
   }

   public function testTransactionNormalizer()
   {
      $adapter = new MT942Normalizer();
      $str = file_get_contents($this->dir . '/transaction.mt942');
      $transaction = $adapter->normalizeTransaction($str);
      $this->assertNotEmpty($transaction);
      return $transaction;
   }

   public function testValidator()
   {
      $transaction = $this->testTransactionNormalizer();
      $validator = Validation::createValidatorBuilder()
         ->addMethodMapping('loadTransactionValidatorMetadata')
         ->getValidator();
      $violationList = $validator->validate($transaction);
      $this->assertEmpty($violationList->count());
   }

}