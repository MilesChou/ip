<?php

namespace Tests\Benchmark;

use MilesChou\Ip\Range;
use PhpBench\Benchmark\Metadata\Annotations\Iterations;
use PhpBench\Benchmark\Metadata\Annotations\Revs;

/**
 * @BeforeMethods({"init"})
 */
class RangeBench
{
    private $item;

    public function init()
    {
        $this->item = array_map(static function ($v) {
            return [$v];
        }, range(100000, 1));
    }

    /**
     * @Revs(5)
     * @Iterations(5)
     */
    public function benchNormal()
    {
        Range::sort($this->item);
    }
}
