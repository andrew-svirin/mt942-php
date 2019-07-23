<?php

namespace AndriySvirin\tests\Unit;

use AndriySvirin\MT942\MT942Normalizer;
use PHPUnit\Framework\TestCase;

final class MT942Test extends TestCase
{

   var $dir = __DIR__ . '/../_data';

   public function testFromString()
   {
      $adapter = new MT942Normalizer();
      $str = file_get_contents($this->dir . '/response.mt942');
      $payments = $adapter->normalize($str);
      $this->assertTrue(true);
   }

}