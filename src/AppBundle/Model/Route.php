<?php
/**
 * Created by PhpStorm.
 * User: mz
 * Date: 29.03.2018
 * Time: 10:06
 */

namespace AppBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

class Route
{
    /** @var ArrayCollection|Station[] */
    private $stations;

    public function __construct(array $stations)
    {
        foreach ($stations as $station) {
            if (!$station instanceof Station) {
                throw new \InvalidArgumentException();
            }
        }

        $this->stations = new ArrayCollection($stations);
    }

    public function nextStation()
    {
        if ($this->isLastStation()) {
            $this->reverse();
        }

        $this->stations->next();
    }

    /**
     * @return Station
     */
    public function getCurrentStation()
    {
        return $this->stations->current();
    }

    public function getCountStations()
    {
        return $this->stations->count();
    }

    public function isLastStation()
    {
        return $this->stations->current() === $this->stations[$this->getCountStations() - 1];
    }

    private function reverse()
    {
        $stations = array_reverse($this->stations->toArray());
        $this->stations->clear();
        foreach ($stations as $station) {
            $this->stations->add($station);
        }
    }
}