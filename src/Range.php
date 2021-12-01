<?php

namespace MilesChou\Ip;

class Range
{
    public static function isValid($range): bool
    {
        if (!is_array($range)) {
            return false;
        }

        if (count($range) !== 2) {
            return false;
        }

        if (!is_int($range[0]) || !is_int($range[1])) {
            return false;
        }

        return true;
    }

    /**
     * Merge list
     *
     * @param array $list Range list
     * @return array
     */
    public static function merge(array $list): array
    {
        return array_reduce(self::sort($list), static function (array $carry, array $value) {
            if (empty($carry)) {
                $carry[] = $value;

                return $carry;
            }

            $last = end($carry);

            if ($last[1] + 1 >= (int)$value[0]) {
                array_pop($carry);

                $carry[] = [$last[0], $value[1]];
            } else {
                $carry[] = $value;
            }

            return $carry;
        }, []);
    }

    /**
     * Sort list
     *
     * @param array $list
     * @param bool $merge
     * @return array
     */
    public static function sort(array $list, bool $merge = false): array
    {
        usort($list, static function ($a, $b) {
            return $a[0] <=> $b[0];
        });

        if ($merge) {
            $list = self::merge($list);
        }

        return $list;
    }

    /**
     * Find index in range data by IP long
     *
     * @param int $ip IP use long int
     * @param array $range Sorted range list
     * @return int|null
     */
    public static function search(int $ip, array $range): ?int
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
}
