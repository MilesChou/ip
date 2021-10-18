<?php

declare(strict_types=1);

namespace MilesChou\Ip\Collection;

class V4 implements CollectionInterface
{
    use CollectionTrait;

    /**
     * Add the private IP
     *
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
     * Add the loopback IP
     *
     * @see https://datatracker.ietf.org/doc/html/rfc6890
     */
    public function addLoopbackIp(): self
    {
        $this->add([
            [2130706432, 2147483647],   // 127.0.0.0    -   127.255.255.255
        ]);

        return $this;
    }

    public function has(string $ip): bool
    {
        return null !== $this->find(ip2long($ip));
    }
}
