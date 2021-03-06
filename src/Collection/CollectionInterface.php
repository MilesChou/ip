<?php

namespace MilesChou\Ip\Collection;

interface CollectionInterface
{
    public function add(int $start, int $end): CollectionInterface;

    public function block(int $start, int $end): CollectionInterface;

    public function has(string $ip): bool;

    public function missing(string $ip): bool;
}
