<?php

namespace AppBundle\Error;

use AppBundle\Error\Error400;

class ParameterNotFound extends Error400
{
    public function __construct($parameter)
    {
        parent::__construct("No se encontró el parámetro $parameter");
    }
}
