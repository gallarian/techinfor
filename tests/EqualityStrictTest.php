<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EqualityStrictTest extends KernelTestCase
{
    public function testEquality(): void
    {
        $this->assertSame(1, 1);
    }
}