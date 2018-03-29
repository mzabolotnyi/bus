<?php
/**
 * Created by PhpStorm.
 * User: mz
 * Date: 29.03.2018
 * Time: 10:33
 */

namespace AppBundle\Model;

class BusFactory
{
    public function create($model, $maxPassengers)
    {
        return new Bus($model, $maxPassengers, new DoorSystem());
    }
}