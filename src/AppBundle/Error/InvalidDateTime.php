<?php

namespace AppBundle\Error;

use AppBundle\Error\Error400;

class InvalidDateTime extends Error400
{
    public function __construct($dateTime, $format = "YYYY-MM-DD")
    {
        parent::__construct("Formato de fecha invalido '{$dateTime}', formato valido '{$format}'.");
    }
}
