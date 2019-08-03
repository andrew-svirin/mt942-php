<?php

namespace AndrewSvirin\tests\Unit;

use AndrewSvirin\MT942\MT942Normalizer;
use PHPUnit\Framework\TestCase;

/**
 * Class MT942Test.
 *
 * @author Andrew Svirin
 */
final class MT942Test extends TestCase
{

   var $dir = __DIR__ . '/../_data';

   public function testFromString()
   {
      $adapter = new MT942Normalizer();
      $str = file_get_contents($this->dir . '/response.mt942');
      $transactions = $adapter->normalize($str);
      $this->assertTrue(true);
   }

}