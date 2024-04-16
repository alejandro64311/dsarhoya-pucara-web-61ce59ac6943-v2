<?php

namespace AppBundle\Error;

use dsarhoya\DSYApiKeyAuthenticatorBundle\Error\BaseApiError;

class Error400 extends BaseApiError
{
    public function __construct($message = 'Ocurrió un error')
    {
        parent::__construct($message, 400);
    }
}
