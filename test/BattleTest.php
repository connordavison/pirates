<?php

use Pirates\Battle;
use Pirates\DamageCalculator;
use Pirates\Ship;

class BattleTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Ship|PHPUnit_Framework_MockObject_MockObject
     */
    protected $playerOne;

    /**
     * @var Ship|PHPUnit_Framework_MockObject_MockObject
     */
    protected $playerTwo;

    /**
     * @var DamageCalculator|PHPUnit_Framework_MockObject_MockObject
     */
    protected $calculator;

    public function setUp()
    {
        $this->playerOne = $this->createMock(Ship::class);
        $this->playerTwo = $this->createMock(Ship::class);
        $this->calculator = $this->createMock(DamageCalculator::class);
    }

    public function testPlayerOneGoesFirst()
    {
        $battle = new Battle($this->playerOne, $this->playerTwo, $this->calculator);

        $this->assertSame($this->playerOne, $battle->getTurnAttacker());
        $this->assertSame($this->playerTwo, $battle->getTurnDefender());
    }

    /**
     * @expectedException        RuntimeException
     * @expectedExceptionMessage Defender is already sunk!
     */
    public function testCannotContinueWithSunkDefender()
    {
        $battle = new Battle($this->playerOne, $this->playerTwo, $this->calculator);

        $this->playerTwo->method('isSunk')->willReturn(true);
        $battle->run();
    }

    public function testTurnAttackerAttacksTurnDefender()
    {
        $battle = new Battle($this->playerOne, $this->playerTwo, $this->calculator);

        $this->calculator->expects($this->once())
            ->method('battle')
            ->with($this->playerOne, $this->playerTwo)
            ->willReturn(20);

        $this->playerTwo->expects($this->once())
            ->method('decreaseHealth')
            ->with(20);

        $battle->run();
    }

    public function testTurnAttackAndDefenderSwapAfterRun()
    {
        $battle = new Battle($this->playerOne, $this->playerTwo, $this->calculator);

        $this->calculator->method('battle')->willReturn(20);

        $battle->run();

        $this->assertSame($this->playerOne, $battle->getTurnDefender());
        $this->assertSame($this->playerTwo, $battle->getTurnAttacker());
    }
}