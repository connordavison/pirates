<?php

namespace Aql;

class Ship
{
    protected $health = 100;

    protected $attackPoints;

    protected $defencePoints;

    public function __construct(int $attackPoints, int $defencePoints)
    {
        $this->attackPoints = $attackPoints;
        $this->defencePoints = $defencePoints;
    }

    public function decreaseHealth(int $amount)
    {
        $this->health -= $amount;
    }

    public function getHealth(): int
    {
        return $this->health;
    }

    public function getAttackPoints(): int
    {
        return $this->attackPoints;
    }

    public function getDefencePoints(): int
    {
        return $this->defencePoints;
    }

    public function isSunk(): bool
    {
        return $this->health <= 0;
    }
}
