<?php

declare(strict_types=1);

namespace Tests\Unit\Range;

use MilesChou\Ip\Range;
use Tests\TestCase;

class RangeSearchTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnNullWhenEmptyArray(): void
    {
        $this->assertNull(Range::search(1, []));
    }

    /**
     * @test
     */
    public function shouldReturnNullWhenArrayRangeIsNotMatch(): void
    {
        $this->assertNull(Range::search(1, [
            [2, 3],
        ]));
    }

    /**
     * @test
     */
    public function shouldReturnIndex0WhenArrayRangeIsMatchIndex10(): void
    {
        $range = [[0, 0], [1, 3], [4, 6]];

        $this->assertSame(0, Range::search(0, $range));
    }

    /**
     * @test
     */
    public function shouldReturnIndex1WhenArrayRangeIsMatchIndex1(): void
    {
        $range = [[0, 0], [1, 3], [4, 6]];

        $this->assertSame(1, Range::search(1, $range));
        $this->assertSame(1, Range::search(2, $range));
        $this->assertSame(1, Range::search(3, $range));
    }

    /**
     * @test
     */
    public function shouldReturnIndex2WhenArrayRangeIsMatchIndex2(): void
    {
        $range = [[0, 0], [1, 3], [4, 6]];

        $this->assertSame(2, Range::search(4, $range));
        $this->assertSame(2, Range::search(5, $range));
        $this->assertSame(2, Range::search(6, $range));
    }
}
