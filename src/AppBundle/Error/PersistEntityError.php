<?php

namespace AppBundle\Error;

use AppBundle\Error\Error400;

class PersistEntityError extends Error400
{
    public function __construct($entity)
    {
        parent::__construct("Hubo un error al persistir la entidad {$entity}");
    }
}
