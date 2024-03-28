<?php

namespace Tests\Unit;

use App\Helpers\FormatHelper;
use PHPUnit\Framework\TestCase;

class MathHelperTest extends TestCase
{
    public function testAdd()
    {
        $result = FormatHelper::add(2, 3);
        $this->assertEquals(5, $result);
    }

    public function testAddWithNegativeNumbers()
    {
        $result = FormatHelper::add(-2, -3);
        $this->assertEquals(-5, $result);
    }

    public function testAddWithZero()
    {
        $result = FormatHelper::add(0, 5);
        $this->assertEquals(5, $result);
    }
}
