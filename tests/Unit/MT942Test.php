<?php

use AndriySvirin\MT942\MT942Adapter;
use PHPUnit\Framework\TestCase;

final class MT942Test extends TestCase
{

   public function testFromString()
   {
      $adapter = new MT942Adapter();
      $str = '111';
      $payments = $adapter->decode($str);
      $this->assertTrue(true);
   }

}