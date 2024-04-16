<?php

namespace AppBundle\Error;

use AppBundle\Error\Error400;

/**
 * Description of InvalidFormError
 *
 * @author snake77se at dsarhoya.cl
 */
class InvalidFormError extends Error400
{
    public function __construct($entity, $errors)
    {
        parent::__construct(sprintf('Error persistiendo la entidad %s: %s', $entity, $errors));
    }
}
