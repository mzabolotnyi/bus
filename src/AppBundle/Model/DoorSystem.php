<?php
/**
 * Created by PhpStorm.
 * User: mz
 * Date: 29.03.2018
 * Time: 10:04
 */

namespace AppBundle\Model;

class DoorSystem
{
    public function open()
    {
        echo 'Doors opened' . PHP_EOL;
    }

    public function close()
    {
        echo 'Doors closed' . PHP_EOL;
    }
}