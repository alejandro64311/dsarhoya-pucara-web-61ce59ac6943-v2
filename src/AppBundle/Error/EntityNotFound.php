<?php

namespace AppBundle\Error;

use AppBundle\Error\Error400;

class EntityNotFound extends Error400
{
    public function __construct($entity, $entityId = 0)
    {
        parent::__construct(sprintf("No se encontró el entidad '%s', %d", $entity, $entityId));
    }
}
