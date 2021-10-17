<?php

declare(strict_types=1);

namespace MilesChou\Ip;

class V4
{
    /**
     * @var array Allow list
     */
    private $allow = [];

    /**
     * @var array Block list
     */
    private $block = [];

    /**
     * Find index in range data by IP long
     */
    public static function findInRange(int $ip, array $range): ?int
    {
        $found = null;

        // Binary search
        $low = 0;
        $upper = count($range) - 1;

        while ($low <= $upper) {
            $mid = (int)(($low + $upper) / 2);

            if ($ip >= $range[$mid][0] && $ip <= $range[$mid][1]) {
                $found = $mid;
                break;
            }

            if ($ip > $range[$mid][1]) {
                $low = $mid + 1;
            } elseif ($ip < $range[$mid][0]) {
                $upper = $mid - 1;
            }
        }

        return $found;
    }

    /**
     * Alias for isTaiwanByIp() method
     */
    public function isTaiwan(string $ip): bool
    {
        return $this->isTaiwanByIp($ip);
    }

    public function isTaiwanByIp(string $ip): bool
    {
        return $this->isTaiwanByLong(ip2long($ip));
    }

    public function isTaiwanByLong(int $ip): bool
    {
        $result = false;

        // Check list to include
        if (null !== self::findInRange($ip, $this->allow)) {
            $result = true;
        }

        // Check list to exclude
        if (null !== self::findInRange($ip, $this->block)) {
            $result = false;
        }

        return $result;
    }

    /**
     * Alias for includeRangeByIp()
     */
    public function includeRange(string $start, string $end): self
    {
        return $this->includeRangeByIp($start, $end);
    }

    /**
     * Use string to mark the Taiwan IP range
     */
    public function includeRangeByIp(string $start, string $end): self
    {
        $this->allow[] = Range::buildByIp($start, $end);

        return $this;
    }

    /**
     * Use long int to mark the Taiwan IP range
     */
    public function includeRangeByLong(int $start, int $end): self
    {
        $this->allow[] = Range::buildByLong($start, $end);

        return $this;
    }

    /**
     * Include the private IP
     *
     * @see https://datatracker.ietf.org/doc/html/rfc1918
     */
    public function includePrivateIp(): self
    {
        $this->includeRange('10.0.0.0', '10.255.255.255');
        $this->includeRange('172.16.0.0', '172.31.255.255');
        $this->includeRange('192.168.0.0', '192.168.255.255');

        return $this;
    }

    /**
     * Alias for excludeRangeByIp()
     */
    public function excludeRange(string $start, string $end): self
    {
        return $this->excludeRangeByIp($start, $end);
    }

    /**
     * Use string to mark the non-Taiwan IP range
     */
    public function excludeRangeByIp(string $start, string $end): self
    {
        $this->block[] = Range::buildByIp($start, $end);

        return $this;
    }

    /**
     * Use long int to mark the non-Taiwan IP range
     */
    public function excludeRangeByLong(int $start, int $end): self
    {
        $this->block[] = Range::buildByLong($start, $end);

        return $this;
    }

    /**
     * Clean all customize ip range
     */
    public function clean(): void
    {
        $this->cleanInclude();
        $this->cleanExclude();
    }

    /**
     * Clean customize include ip range
     */
    public function cleanInclude(): void
    {
        $this->allow = [];
    }

    /**
     * Clean customize exclude ip range
     */
    public function cleanExclude(): void
    {
        $this->block = [];
    }
}
