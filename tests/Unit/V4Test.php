<?php

declare(strict_types=1);

namespace Tests\Unit;

use MilesChou\Ip\V4;
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

        $this->assertFalse($target->isTaiwan('202.39.145.2'));
    }

    /**
     * @test
     */
    public function shouldReturnFalseWhenTaiwanIp(): void
    {
        $this->assertFalse($this->target->isTaiwan('127.0.0.1'));
    }

    /**
     * @test
     */
    public function shouldReturnFalseWhenNotTaiwanLong(): void
    {
        // 2130706433 means 127.0.0.1
        $this->assertFalse($this->target->isTaiwanByLong(2130706433));
    }

    /**
     * @test
     */
    public function shouldReturnTrueWhenIpInCustomizeRange(): void
    {
        $this->target->includeRange('127.0.0.1', '127.0.0.1');

        $this->assertTrue($this->target->isTaiwan('127.0.0.1'));
    }

    /**
     * @test
     */
    public function shouldReturnTrueWhenLongInCustomizeRange(): void
    {
        // 2130706433 means 127.0.0.1
        $this->target->includeRangeByLong(2130706433, 2130706433);

        $this->assertTrue($this->target->isTaiwan('127.0.0.1'));
    }

    /**
     * @test
     */
    public function shouldReturnFalseWhenIpInExcludeRange(): void
    {
        $this->target->excludeRange('202.39.128.1', '202.39.128.3');

        // After exclude will return false
        $this->assertFalse($this->target->isTaiwan('202.39.128.1'));
        $this->assertFalse($this->target->isTaiwan('202.39.128.2'));
        $this->assertFalse($this->target->isTaiwan('202.39.128.3'));
    }

    /**
     * @test
     */
    public function shouldReturnFalseWhenLongInExcludeRange(): void
    {
        $this->target->excludeRangeByLong(3391586305, 3391586307);

        // After exclude will return false
        $this->assertFalse($this->target->isTaiwanByLong(3391586305));
        $this->assertFalse($this->target->isTaiwanByLong(3391586306));
        $this->assertFalse($this->target->isTaiwanByLong(3391586307));
    }

    /**
     * @test
     */
    public function excludeShouldOverwriteConfig(): void
    {
        // 2130706433 means 127.0.0.1
        $this->target->includeRangeByLong(2130706433, 2130706433);

        $this->assertTrue($this->target->isTaiwan('127.0.0.1'));
    }
}
