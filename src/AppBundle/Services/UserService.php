<?php
namespace AppBundle\Services;

use AppBundle\Services\BaseService;
use AppBundle\Entity\Company;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * User service
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */

class UserService extends BaseService
{
    /**
     * @var EncoderFactoryInterface
     */
    private $encoderFactory;

    /**
     * Constructor
     *
     * @param EntityManagerInterface $em
     * @param EncoderFactoryInterface $encoderFactory
     */
    public function __construct(
        EntityManagerInterface $em,
        EncoderFactoryInterface $encoderFactory
    ) {
        parent::__construct($em);
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * New user by role
     *
     * @param string|null $role
     * @param Company|null $role
     * @return User
     */
    public function newUser(string $role = null, Company $company = null)
    {
        if (null === $company) {
            $company = $this->getCompany();
        }
        return (new User($role))->setCompany($company);
    }

    /**
     * Set user password
     *
     * @param User $user
     * @param string $salt
     * @param string $password
     * @return User
     */
    public function setUserPassword(User $user, string $salt, string $password)
    {
        $encoder = $this->encoderFactory->getEncoder($user);

        if (null === $user->getSalt()) {
            $salt = md5(rand(1, 1000) . $salt);
            $user->setSalt($salt);
        }
        $user->setPassword($encoder->encodePassword($password, $user->getSalt()));

        return $user;
    }
}
