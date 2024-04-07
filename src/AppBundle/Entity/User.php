<?php 

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use dsarhoya\BaseBundle\Entity\BaseUser;
use dsarhoya\BaseBundle\Entity\BaseUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class User extends BaseUser implements BaseUserInterface
{
    const ROLE_ADMIN = 'ROLE_ADMIN';

    const EMAILSENDER_ACTIVE = 1;
    const EMAILSENDER_INACTIVE = 0;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="dsarhoya\BaseBundle\Entity\UserKey", mappedBy="user")
     */
    private $keys;

    /**
     * @var \AppBundle\Entity\Company
     *
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="users")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $company;

    /**
     * @var \AppBundle\Entity\Profile
     *
     * @ORM\ManyToOne(targetEntity="Profile", inversedBy="users")
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $profile;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("api_key")
     * @JMS\Groups({"api_login"})
     */
    private $apiKey;

    /**
     * Constructor
     */
    public function __construct($role = self::ROLE_ADMIN)
    {
        parent::__construct();
        $this->role = $role;
        $this->keys = new ArrayCollection();
    }

    /**
     * Add key.
     *
     * @param \dsarhoya\BaseBundle\Entity\UserKey $key
     *
     * @return User
     */
    public function addKey(\dsarhoya\BaseBundle\Entity\UserKey $key)
    {
        $this->keys[] = $key;

        return $this;
    }

    /**
     * Remove key.
     *
     * @param \dsarhoya\BaseBundle\Entity\UserKey $key
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeKey(\dsarhoya\BaseBundle\Entity\UserKey $key)
    {
        return $this->keys->removeElement($key);
    }

    /**
     * Get keys.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getKeys()
    {
        return $this->keys;
    }

    /**
     * Set company.
     *
     * @param \AppBundle\Entity\Company|null $company
     *
     * @return User
     */
    public function setCompany(\AppBundle\Entity\Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company.
     *
     * @return \AppBundle\Entity\Company|null
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set profile.
     *
     * @param \AppBundle\Entity\Profile|null $profile
     *
     * @return User
     */
    public function setProfile(\AppBundle\Entity\Profile $profile = null)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Set role.
     *
     * @param string $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role.
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set apiKey.
     *
     * @param string $apiKey
     *
     * @return User
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Get apiKey.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Sets updatedAt.
     *
     * @param  \DateTime $updatedAt
     * @return $this
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Returns updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Get Roles
     *
     * @return array
     */
    public function getRoles()
    {
        return [self::ROLE_ADMIN];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    // public function isActive()
    // {
    //     return $this->isEnabled();
    // }

    /**
     * @return integer
     */
    public function getCompanyId()
    {
        return $this->getCompany()->getId();
    }

    /**
     * @return array
     */
    public static function getStateTypes() : array
    {
        return [
            self::ESTADO_ACTIVO => 'Activo',
            self::ESTADO_BLOQUEADO => 'Bloqueado',
        ];
    }

    /**
     * @return array
     */
    public static function getRoleTypes() : array
    {
        return [
            self::ROLE_ADMIN => 'Administrador',
        ];
    }

    /**
     * @return array
     */
    public static function getAccountValidatedTypes() : array
    {
        return [
            self::ACCOUNT_VALIDATED => 'Válida',
            self::ACCOUNT_NOT_VALIDATED => 'No válida',
        ];
    }
}
