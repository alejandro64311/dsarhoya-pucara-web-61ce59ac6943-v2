<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Controller\Admin\BaseEAdminController;
use dsarhoya\BaseBundle\Options\UserManagementDeleteOptions;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\User;
use AppBundle\Entity\Company;
use AppBundle\Services\UserService;

/**
 * User Controller
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class UserController extends BaseEAdminController
{
    /**
     * @var UserService
     */
    private $userSrv;

    /**
     * Constructor
     *
     * @param UserService $userSrv
     */
    public function __construct(UserService $userSrv)
    {
        $this->userSrv = $userSrv;
    }

    /**
     * Get new user role
     *
     * @return string
     */
    protected function getNewUserRole() : string
    {
        return User::ROLE_ADMIN;
    }

    /**
     * Get email sender status
     *
     * @return string
     */
    protected function getEmailSender() : string
    {
        return User::EMAILSENDER_ACTIVE;
    }

    /**
     * Get profile
     *
     * @return \AppBundle\Entity\Profile|null
     */
    protected function getProfile()
    {
        return $this->getRepoProfile()->findOneBy([
            'isAdmin' => true,
        ]);
    }

    /**
     * Get profile
     *
     * @return boolean
     */
    protected function getValidateAccount()
    {
        return User::ACCOUNT_NOT_VALIDATED;
    }

    /**
     * {@inheritDoc}
     */
    protected function createNewEntity()
    {
        if (!in_array($this->request->query->get('entity'), ['Admin'])) {
            return parent::createNewEntity();
        }
        $entity = $this->userSrv->newUser($this->getNewUserRole());
        $entity->setProfile($this->getProfile());
        $entity->setEmailSender($this->getEmailSender());
        $entity->setAccountValidated($this->getValidateAccount());
        return $entity;
    }

    /**
     * {@inheritDoc}
     */
    protected function persistEntity($entity)
    {
        if (!$entity instanceof User || null === $entity->getEmail()) {
            return parent::persistEntity($entity);
        }
        $this->flashSuccess($this->getServiceTranslator()->trans('success.user.created'));
        $this->getServiceUserManagementService()->persistUser($entity);
    }

    /**
     * {@inheritDoc}
     */
    protected function updateEntity($entity)
    {
        if (!$entity instanceof User) {
            return parent::updateEntity($entity);
        }
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        /** @var User $entity */
        if (User::ESTADO_BLOQUEADO === $entity->getState() && $currentUser->getId() === $entity->getId()) {
            $this->flashError('No puedes bloquear tu propio usuario');
            return $this->redirectToReferrer();
        }
        if (User::ESTADO_BLOQUEADO === $entity->getState() && false === $this->em->getRepository(User::class)->otherAdminUser($entity, User::class)) {
            $this->flashError("El sistema no puede quedar sin usuarios administradores");
            return $this->redirectToReferrer();
        }

        $this->getServiceUserManagementService()->updateUser($entity);
        $this->flashSuccess($this->getServiceTranslator()->trans('success.user.updated'));
    }

    /**
     * {@inheritDoc}
     */
    public function removeEntity($entity)
    {
        if (!$entity instanceof User) {
            return parent::removeEntity($entity);
        }
        if (false === $this->em->getRepository(User::class)->otherAdminUser($entity, User::class)) {
            $this->flashError("El sistema no puede quedar sin usuarios administradores");
            return $this->redirectToReferrer();
        }
        if ($this->getServiceUserManagementService()->removeUser($entity, new UserManagementDeleteOptions())) {
            $this->flashSuccess($this->getServiceTranslator()->trans('success.user.deleted'));
        } else {
            $this->flashError($this->getServiceTranslator()->trans($this->getServiceUserManagementService()->getErrorsAsString()));
        }
    }
}
