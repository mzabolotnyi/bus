<?php
/**
 * Created by PhpStorm.
 * User: mz
 * Date: 29.03.2018
 * Time: 10:33
 */

namespace AppBundle\Model;

class RouteFactory
{
    public function createRandom($countStations)
    {
        $stations = [];

        for ($i = 1; $i <= $countStations; $i++) {
            array_push($stations, new Station('Station ' . $i));
        }

        return new Route($stations);
    }
}