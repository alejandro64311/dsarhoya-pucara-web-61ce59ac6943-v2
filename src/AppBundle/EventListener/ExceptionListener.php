<?php

namespace AppBundle\EventListener;

use dsarhoya\DSYApiKeyAuthenticatorBundle\EventListener\ExceptionListener as EL;
use dsarhoya\DSYApiKeyAuthenticatorBundle\Error\BaseApiError;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Psr\Log\LoggerInterface;

class ExceptionListener extends EL
{
    /**
     * @var LoggerInterface
     */
    private $log;

    /**
     * Constructor
     *
     * @param [type] $errorCodes
     * @param LoggerInterface $log
     */
    public function __construct($errorCodes, LoggerInterface $log)
    {
        parent::__construct($errorCodes);
        $this->log = $log;
    }

    /**
     * onKernelException
     *
     * @param GetResponseForExceptionEvent $event
     * @return void
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        parent::onKernelException($event);
        
        $exception = $event->getException();
        if (!($exception instanceof BaseApiError)) {
            return ;
        }
        $this->log->error('Error en la api.', ['exception' => $event->getException()]);
    }
}
