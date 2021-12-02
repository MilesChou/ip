<?php

declare(strict_types=1);

namespace MilesChou\Ip\Collection;

use InvalidArgumentException;
use MilesChou\Ip\Cidr;
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
        foreach ($list as $item) {
            if (Cidr::isValid($item)) {
                $item = Cidr::toRange($item);
            } elseif (!Range::isValid($item)) {
                continue;
            }

            $this->list[] = $item;
        }

        $this->list = Range::merge($this->list);

        return $this;
    }

    /**
     * @param string $cidr
     * @return $this
     */
    public function addCidr(string $cidr): V4
    {
        return $this->add([Cidr::toRange($cidr)]);
    }

    /**
     * @param array $range
     * @return $this
     */
    public function addRange(array $range): V4
    {
        if (!Range::isValid($range)) {
            throw new InvalidArgumentException('Invalid range');
        }

        return $this->add([$range]);
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

    public function all(): array
    {
        return $this->list;
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
        return $this->hasLong(ip2long($ip));
    }

    /**
     * @param int $long
     * @return bool
     */
    public function hasLong(int $long): bool
    {
        return null !== $this->find($long);
    }

    /**
     * Flush the range list
     */
    public function flush(): void
    {
        $this->list = [];
    }
}
