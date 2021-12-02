<?php

declare(strict_types=1);

namespace Tests\Unit\Collection;

use MilesChou\Ip\Collection\V4;
use Tests\TestCase;

class V4Test extends TestCase
{
    /**
     * @var V4
     */
    private $target;

    protected function setUp(): void
    {
        $this->target = new V4();
    }

    /**
     * @test
     */
    public function shouldReturnFalseWhenNewObject(): void
    {
        $target = new V4();

        $this->assertFalse($target->has('127.0.0.1'));
    }

    /**
     * @test
     */
    public function shouldReturnTrueWhenIpInCustomizeRange(): void
    {
        // 2130706433 means 127.0.0.1
        $this->target->add([[2130706433, 2130706433]]);

        $this->assertTrue($this->target->has('127.0.0.1'));
    }

    /**
     * @test
     */
    public function shouldReturnTrueWhenUsingLoopbackIp(): void
    {
        $this->target->addLoopbackIp();

        $this->assertTrue($this->target->has('127.0.0.0'));
        $this->assertTrue($this->target->has('127.255.255.255'));
    }

    /**
     * @test
     */
    public function shouldReturnTrueWhenUsingLoopbackIpByAddCidr(): void
    {
        $this->target->addCidr('127.0.0.0/8');

        $this->assertTrue($this->target->has('127.0.0.0'));
        $this->assertTrue($this->target->has('127.255.255.255'));
    }

    /**
     * @test
     */
    public function shouldReturnTrueWhenUsingLoopbackIpByAddRange(): void
    {
        $this->target->addRange([2130706432, 2147483647]);

        $this->assertTrue($this->target->has('127.0.0.0'));
        $this->assertTrue($this->target->has('127.255.255.255'));
    }

    /**
     * @test
     */
    public function shouldReturnTrueWhenUsingPrivateIp(): void
    {
        $this->target->addPrivateIp();

        $this->assertTrue($this->target->has('10.11.12.13'));
        $this->assertTrue($this->target->has('172.22.4.1'));
        $this->assertTrue($this->target->has('192.168.200.100'));
    }

    /**
     * @test
     */
    public function shouldReturnFalseWhenFlush(): void
    {
        // 2130706433 means 127.0.0.1
        $this->target->add([[2130706433, 2130706433]]);

        $this->assertTrue($this->target->has('127.0.0.1'));

        $this->target->flush();

        $this->assertFalse($this->target->has('127.0.0.1'));
    }

    /**
     * @test
     */
    public function shouldReturnWhenAddNewItem(): void
    {
        $this->target->addRange([1, 2]);

        $this->assertTrue($this->target->hasLong(1));
        $this->assertTrue($this->target->hasLong(2));

        $this->target->addRange([3, 4]);

        $this->assertTrue($this->target->hasLong(1));
        $this->assertTrue($this->target->hasLong(2));
        $this->assertTrue($this->target->hasLong(3));
        $this->assertTrue($this->target->hasLong(4));
    }
}
