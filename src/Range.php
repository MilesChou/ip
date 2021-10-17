<?php

namespace MilesChou\Ip;

class Range
{
    /**
     * Build ip range data by IP
     */
    public static function buildByIp(string $start, string $end): array
    {
        return self::buildByLong(ip2long($start), ip2long($end));
    }

    /**
     * Build ip range data by Long
     */
    public static function buildByLong(int $start, int $end): array
    {
        return [$start, $end];
    }
}
