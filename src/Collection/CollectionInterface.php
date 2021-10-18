<?php

namespace MilesChou\Ip\Collection;

interface CollectionInterface
{
    public function has(string $ip): bool;
}
