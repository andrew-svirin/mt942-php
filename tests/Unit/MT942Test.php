<?php

namespace AndrewSvirin\tests\Unit;

use AndrewSvirin\MT942\MT942Normalizer;
use AndrewSvirin\MT942\MT942Validator;
use PHPUnit\Framework\TestCase;

/**
 * Class MT942Test.
 *
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @author Andrew Svirin
 */
final class MT942Test extends TestCase
{

   var $dir = __DIR__ . '/../_data';

   public function testTransactionListNormalization()
   {
      $adapter = new MT942Normalizer();
      $str = file_get_contents($this->dir . '/transactions.mt942');
      $transactionList = $adapter->normalize($str);
      $this->assertNotEmpty($transactionList->count());
      return $transactionList;
   }

   public function testTransactionNormalization()
   {
      $adapter = new MT942Normalizer();
      $str = file_get_contents($this->dir . '/transaction.mt942');
      $transaction = $adapter->normalizeTransaction($str);
      $this->assertNotEmpty($transaction);
      return $transaction;
   }

   public function testTransactionListValidation()
   {
      $transactionList = $this->testTransactionListNormalization();
      $transactionValidator = new MT942Validator();
      $violationList = $transactionValidator->validateList($transactionList);
      $this->assertEmpty($violationList->count());
   }

   public function testTransactionValidation()
   {
      $transaction = $this->testTransactionNormalization();
      $transactionValidator = new MT942Validator();
      $violationList = $transactionValidator->validate($transaction);
      $this->assertEmpty($violationList->count());
   }

}