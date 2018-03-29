<?php
/**
 * Created by PhpStorm.
 * User: mz
 * Date: 29.03.2018
 * Time: 10:15
 */

namespace AppBundle\Model;

use AppBundle\Exception\PassengersLimitException;
use AppBundle\Exception\RouteNotSetException;
use Doctrine\Common\Collections\ArrayCollection;

class Bus
{
    private $model;

    private $maxPassengers;

    /** @var ArrayCollection|Passenger[] */
    private $passengers;

    /** @var DoorSystem */
    private $doorSystem;

    /** @var Route */
    private $route;

    public function __construct($model, $maxPassengers, DoorSystem $doorSystem)
    {
        $this->model = $model;
        $this->maxPassengers = $maxPassengers;
        $this->doorSystem = $doorSystem;
        $this->passengers = new ArrayCollection();
    }

    public function setRoute(Route $route)
    {
        $this->route = $route;
    }

    public function moveToNextStation()
    {
        if (is_null($this->route)) {
            throw new RouteNotSetException();
        }

        $this->route->nextStation();
        echo 'Arrived to station ' . $this->route->getCurrentStation() . PHP_EOL;
    }

    public function getCurrentStation()
    {
        return $this->route->getCurrentStation();
    }

    public function openDoors()
    {
        $this->doorSystem->open();
    }

    public function closeDoors()
    {
        $this->doorSystem->close();
    }

    public function getPassengers()
    {
        return $this->passengers;
    }

    public function letInPassenger(Passenger $passenger)
    {
        if ($this->passengers->count() >= $this->maxPassengers) {
            throw new PassengersLimitException();
        }

        $this->passengers->add($passenger);
        echo $passenger . ' let in bus' . PHP_EOL;
    }

    public function letOutPassenger(Passenger $passenger)
    {
        $this->passengers->removeElement($passenger);
        echo $passenger . ' let out bus' . PHP_EOL;
    }

    public function letOutAll()
    {
        foreach ($this->passengers as $passenger) {
            $this->letOutPassenger($passenger);
        }
    }

    public function wait($minutes)
    {
        echo 'Waiting for ' . $minutes . ' minutes' . PHP_EOL;
    }

    public function isFull()
    {
        return $this->passengers->count() >= $this->maxPassengers;
    }

    public function isLastStation()
    {
        return $this->route->isLastStation();
    }

    public function __toString()
    {
        return 'Bus '. $this->model;
    }
}