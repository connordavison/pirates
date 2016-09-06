<?php

namespace Pirates\Command;

use Pirates\Battle;
use Pirates\DamageCalculator;
use Pirates\Ship;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BattleCommand extends Command
{
    protected function configure()
    {
        $this->setName('pirates:battle')
            ->setDescription('Battle two ships! Example usage: bin/console pirates:battle 15 10 30 20')
            ->addArgument('player_one.attack_points', InputArgument::REQUIRED, 'The attack points for player one')
            ->addArgument('player_one.defence_points', InputArgument::REQUIRED, 'The defence points for player one')
            ->addArgument('player_two.attack_points', InputArgument::REQUIRED, 'The attack points for player two')
            ->addArgument('player_two.defence_points', InputArgument::REQUIRED, 'The defence points for player two');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $playerOne = new Ship(
            $input->getArgument('player_one.attack_points'),
            $input->getArgument('player_one.defence_points')
        );

        $playerTwo = new Ship(
            $input->getArgument('player_two.attack_points'),
            $input->getArgument('player_two.defence_points')
        );

        $calculator = new DamageCalculator();

        $battle = new Battle($playerOne, $playerTwo, $calculator);

        while (!$battle->isGameOver()) {
            $battle->run();

            $message = sprintf(
                "\rPlayer one: %d, player two: %d",
                $playerOne->getHealth(),
                $playerTwo->getHealth()
            );

            $output->writeln($message);
            usleep(1e5);
        }

        $message = sprintf(
            "Player %s wins!",
            $battle->getWinner() === $playerOne ? 'one' : 'two'
        );

        $output->writeln($message);
    }
}
