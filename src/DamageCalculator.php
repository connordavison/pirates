<?php

namespace Aql;

class DamageCalculator
{
    public function battle(Ship $attacker, Ship $defender): int
    {
        if (!$this->passesAccuracyCheck()) {
            return 0;
        }

        $damage = $attacker->getAttackPoints();

        if ($this->passesCriticalCheck()) {
            $damage *= 3;
        }

        $damage = max(0, $damage - $defender->getDefencePoints());

        return $damage;
    }

    protected function passesAccuracyCheck(): bool
    {
        return rand(0, 100) < 25;
    }

    protected function passesCriticalCheck(): bool
    {
        return rand(0, 100) < 10;
    }
}
