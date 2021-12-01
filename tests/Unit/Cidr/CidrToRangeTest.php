<?php

declare(strict_types=1);

namespace Tests\Unit\Cidr;

use InvalidArgumentException;
use MilesChou\Ip\Cidr;
use Tests\TestCase;

class CidrToRangeTest extends TestCase
{
    public function invalidCidr(): iterable
    {
        yield ['whatever'];
        yield ['not_ip/16'];
        yield ['127.0.0.1'];
        yield ['127.0.0.1/whatever'];
        yield ['127.0.0.1/33'];
    }

    /**
     * @test
     * @dataProvider invalidCidr
     */
    public function shouldThrowExceptionWhenInvalidCidr($invalidCidr): void
    {
        $this->expectException(InvalidArgumentException::class);

        Cidr::toRange($invalidCidr);
    }

    /**
     * @test
     */
    public function shouldReturnCorrectResult(): void
    {
        $this->assertSame([167772160, 184549375], Cidr::toRange('10.0.0.0/8'));
        $this->assertSame([2886729728, 2887778303], Cidr::toRange('172.16.0.0/12'));
        $this->assertSame([3232235520, 3232301055], Cidr::toRange('192.168.0.0/16'));
        $this->assertSame([2130706432, 2147483647], Cidr::toRange('127.0.0.0/8'));
    }
}
