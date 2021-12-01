<?php

namespace MilesChou\Ip;

use InvalidArgumentException;

class Cidr
{
    public static function isValid($cidr): bool
    {
        if (!is_string($cidr)) {
            return false;
        }

        $part = explode('/', $cidr);

        if (count($part) !== 2) {
            return false;
        }

        $ip = $part[0];
        $bits = (int)$part[1];

        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return false;
        }

        if ($bits < 1 || $bits > 32) {
            return false;
        }

        return true;
    }

    /**
     * To int range from CIDR
     *
     * @param string $cidr
     * @return array
     */
    public static function toRange(string $cidr): array
    {
        if (!self::isValid($cidr)) {
            throw new InvalidArgumentException('Invalid CIDR pattern: ' . $cidr);
        }

        [$ip, $bits] = explode('/', $cidr);

        return [
            ip2long($ip) & (-1 << (32 - $bits)),
            ip2long($ip) + pow(2, (32 - $bits)) - 1,
        ];
    }
}
