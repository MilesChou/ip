<?php

declare(strict_types=1);

namespace Tests\Unit\Range;

use MilesChou\Ip\Range;
use Tests\TestCase;

class RangeMergeTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnEmptyArrayWhenEmptyArray(): void
    {
        $this->assertSame([], Range::merge([]));
    }

    /**
     * @test
     */
    public function shouldReturnSameArrayWhenArrayIsNecessaryMerge(): void
    {
        $range = [
            [1, 2],
            [4, 5],
            [7, 8],
        ];

        $this->assertSame($range, Range::merge($range));
    }

    /**
     * @test
     */
    public function shouldReturnShortArrayWhenArrayIsNeedMerge(): void
    {
        $list = [
            [1, 2],
            [3, 4],
            [5, 6],
        ];

        $expected = [
            [1, 6],
        ];

        $this->assertSame($expected, Range::merge($list));
    }

    /**
     * @test
     */
    public function shouldReturnShortArrayWhenArrayIsNeedMergeWhenCrossRange(): void
    {
        $list = [
            [1, 3],
            [2, 4],
            [4, 6],
        ];

        $expected = [
            [1, 6],
        ];

        $this->assertSame($expected, Range::merge($list));
    }

    /**
     * @test
     */
    public function shouldReturnShortArrayWhenArrayIsNeedMergeWhenSameRange(): void
    {
        $list = [
            [1, 3],
            [1, 3],
            [4, 6],
        ];

        $expected = [
            [1, 6],
        ];

        $this->assertSame($expected, Range::merge($list));
    }

    /**
     * @test
     */
    public function shouldReturnSortedAndMergedArray(): void
    {
        $list = [
            [5, 6],
            [3, 4],
            [1, 2],
        ];

        $expected = [
            [1, 6],
        ];

        $this->assertSame($expected, Range::merge($list));
    }
}
