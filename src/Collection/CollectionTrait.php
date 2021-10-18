<?php

namespace MilesChou\Ip\Collection;

use MilesChou\Ip\Range;

trait CollectionTrait
{
    /**
     * @var array Range list
     */
    private $range = [];

    /**
     * @param array $list
     * @return $this
     */
    public function add(array $list)
    {
        $this->range = Range::sort($this->range + $list);

        return $this;
    }

    /**
     * @param int $ip
     * @return int|null
     */
    public function find(int $ip): ?int
    {
        return Range::search($ip, $this->range);
    }

    /**
     * Flush the range list
     */
    public function flush(): void
    {
        $this->range = [];
    }
}
