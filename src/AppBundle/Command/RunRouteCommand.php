<?php

namespace AppBundle\Command;

use AppBundle\Exception\PassengersLimitException;
use AppBundle\Model\Bus;
use AppBundle\Model\BusFactory;
use AppBundle\Model\Passenger;
use AppBundle\Model\RouteFactory;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RunRouteCommand extends ContainerAwareCommand
{
    const NAME = 'app:route:run';

    protected function configure()
    {
        $this->setName(self::NAME);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $routeFactory = new RouteFactory();
        $route = $routeFactory->createRandom(5);

        $busFactory = new BusFactory();
        $bus = $busFactory->create('LAZ', 15);
        $bus->setRoute($route);

        $output->writeln($bus . ' started route from station ' . $bus->getCurrentStation());
        $iterations = $route->getCountStations() * 2 - 2;

        for ($i = 0; $i < $iterations; $i++) {

            $bus->moveToNextStation();
            $bus->openDoors();

            sleep(1);

            if ($bus->isLastStation()) {
                $bus->letOutAll();
            } else {
                for ($j = 0; $j < rand(0, 5); $j++) {
                    $this->letOutRandomBusPassenger($bus);
                }
            }

            $passengers = $this->getRandomPassengers();

            foreach ($passengers as $passenger) {
                try {
                    $bus->letInPassenger($passenger);
                } catch (PassengersLimitException $e) {
                    $output->writeln($bus . ' is full!');
                }
            }

            if (!$bus->isFull()) {
                $bus->wait(1);
                sleep(3);
            }

            $bus->closeDoors();
        }
    }

    private function getRandomPassengers()
    {
        $names = [
            'Jame',
            'Pit',
            'Jack',
            'Mark',
            'Tom',
            'Garry',
            'Liza',
            'Sam',
            'Alex',
            'Ketty',
            'Angelina',
            'Max'
        ];

        $passengers = [];

        for ($i = 0; $i < rand(3, 5); $i++) {
            $passengers[] = new Passenger($names[rand(0, count($names) - 1)]);
        }

        return $passengers;
    }

    private function letOutRandomBusPassenger(Bus $bus)
    {
        $passenger = $bus->getPassengers()->first();

        if ($passenger) {
            $bus->letOutPassenger($passenger);
        }
    }
}