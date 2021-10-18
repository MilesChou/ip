<?php

declare(strict_types=1);

namespace Tests\Unit\Range;

use MilesChou\Ip\Range;
use Tests\TestCase;

class RangeSortTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnEmptyArrayWhenEmptyArray(): void
    {
        $this->assertSame([], Range::sort([]));
    }

    /**
     * @test
     */
    public function shouldReturnSameArrayWhenArrayIsSorted(): void
    {
        $range = [
            [1, 2],
            [3, 4],
            [5, 6],
        ];

        $this->assertSame($range, Range::sort($range));
    }

    /**
     * @test
     */
    public function shouldReturnSortedArray(): void
    {
        $range = [
            [5, 6],
            [3, 4],
            [1, 2],
        ];

        $expected = [
            [1, 2],
            [3, 4],
            [5, 6],
        ];

        $this->assertSame($expected, Range::sort($range));
    }
}
