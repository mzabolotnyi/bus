<?php
/**
 * Created by PhpStorm.
 * User: mz
 * Date: 29.03.2018
 * Time: 10:07
 */

namespace AppBundle\Model;

class Passenger
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}