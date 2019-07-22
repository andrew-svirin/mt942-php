<?php

use AndriySvirin\MT942\MT942Adapter;
use PHPUnit\Framework\TestCase;

final class MT942Test extends TestCase
{

   var $dir = __DIR__ . '/../_data';

   public function testFromString()
   {
      $adapter = new MT942Adapter();
      $str = file_get_contents($this->dir . '/response.mt942');
      $payments = $adapter->decode($str);
      $this->assertTrue(true);
   }

}