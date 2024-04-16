<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Gedmo\Blameable\BlameableListener;

/**
 * BlameableListener
 *
 * @author David Buchmann <mail@davidbu.ch>
 */
class BlameListener 
{
    /**
     * @var BlameableListener
     */
    private $blameableListener;
    private $user;
    
    public function __construct(BlameableListener $blameableListener, TokenStorage $token_storage)
    {
        $this->blameableListener = $blameableListener;
        
        if (null === $token = $token_storage->getToken()) {
            return;
        }
        
        if (!is_object($user = $token->getUser())) {
            return;
        }
        
        $this->user = $user;
    }

    /**
     * Set the username from the security context by listening on core.request
     *
     * @param GetResponseEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        if (null === $this->user) {
            return;
        }
        
        $this->blameableListener->setUserValue($this->user);
    }
}
