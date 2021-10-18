<?php

namespace MilesChou\Ip;

class Range
{
    /**
     * Sort range list
     *
     * @param array $range Range list
     * @return array
     */
    public static function sort(array $range): array
    {
        usort($range, static function ($a, $b) {
            return $a[0] <=> $b[0];
        });

        return $range;
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
