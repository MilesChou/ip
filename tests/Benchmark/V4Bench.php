<?php

namespace Tests\Benchmark;

use MilesChou\Ip\Collection\V4;
use PhpBench\Benchmark\Metadata\Annotations\Iterations;
use PhpBench\Benchmark\Metadata\Annotations\Revs;

use function range;

class V4Bench
{
    /**
     * @Revs(5)
     * @Iterations(5)
     */
    public function benchAddManyItem()
    {
        $collection = new V4();

        foreach (range(1, 100000) as $item) {
            $collection->add($item, $item);
        }
    }
}
