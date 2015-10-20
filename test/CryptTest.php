<?php

use arthurfurlan\crypt\Crypt;

class CryptTest extends PHPUnit_Framework_TestCase
{
  public function testDefaultConstructorSymmetry()
  {
    $source = 'The quick brown fox jumps over the lazy dog';

    $crypt = new Crypt();
    $encrypted = $crypt->encrypt($source);
    $expected = '351a114804070f16194c031c33141c59161b2463180c1d0412521b1e100046011a0941023d190b59141b3b';
    $this->assertEquals($expected, $encrypted);

    $crypt = new Crypt();
    $decrypted = $crypt->decrypt($expected);
    $this->assertEquals($source, $decrypted);
  }

  public function testKeyVariationsGiveSalt()
  {
    $source = 'The quick brown fox jumps over the lazy dog';

    $crypt = new Crypt();
    $encrypted = $crypt->encrypt($source);

    $crypt = new Crypt(null, mt_rand(12357435, 687654532));
    $enc2 = $crypt->encrypt($source);

    $this->assertNotEquals($encrypted, $enc2);

    $crypt = new Crypt(null, 'some entropy' . mt_rand(127435, 688764532));
    $enc3 = $crypt->encrypt($source);
    $this->assertNotEquals($encrypted, $enc3);
    $this->assertNotEquals($enc2, $enc3);

  }
}
