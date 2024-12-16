<?php

namespace Threecolts\Phptest;

use PHPUnit\Framework\TestCase;

final class HelloTest extends TestCase
{
    /** @tests */
    public function TestRun()
    {
        $this->assertSame((new Hello())?->run(), "Hello!\n");
    }
}
