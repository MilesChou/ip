<?php

declare(strict_types=1);

namespace MilesChou\Ip\Collection;

use MilesChou\Ip\Range;

class V4 implements CollectionInterface
{
    /**
     * @var array
     */
    private $list = [];

    /**
     * @param array $list
     * @return $this
     */
    public function add(array $list): V4
    {
        $this->list = Range::sort($this->list + $list);

        return $this;
    }

    /**
     * @see https://datatracker.ietf.org/doc/html/rfc1918
     */
    public function addPrivateIp(): self
    {
        $this->add([
            [167772160, 184549375],     // 10.0.0.0     -   10.255.255.255
            [2886729728, 2887778303],   // 172.16.0.0   -   172.31.255.255
            [3232235520, 3232301055],   // 192.168.0.0  -   192.168.255.255
        ]);

        return $this;
    }

    /**
     * @see https://datatracker.ietf.org/doc/html/rfc6890
     */
    public function addLoopbackIp(): self
    {
        $this->add([
            [2130706432, 2147483647],   // 127.0.0.0    -   127.255.255.255
        ]);

        return $this;
    }

    /**
     * @param int $ip
     * @return int|null
     */
    public function find(int $ip): ?int
    {
        return Range::search($ip, $this->list);
    }

    /**
     * @param string $ip
     * @return bool
     */
    public function has(string $ip): bool
    {
        return null !== $this->find(ip2long($ip));
    }

    /**
     * Flush the range list
     */
    public function flush(): void
    {
        $this->list = [];
    }
}
