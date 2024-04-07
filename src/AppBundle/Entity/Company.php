<?php 

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use dsarhoya\BaseBundle\Entity\BaseCompany;
use Doctrine\Common\Collections\ArrayCollection;
use dsarhoya\DSYFilesBundle\Interfaces\IFileEnabledEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use dsarhoya\BaseBundle\Validator\Constraints as DSYConstrainst;

/**
 * Company
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompanyRepository")
 */
class Company extends BaseCompany // implements IFileEnabledEntity
{
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Profile", mappedBy="company")
     */
    private $profiles;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="User", mappedBy="company")
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->state = self::ESTADO_ACTIVA;
        $this->users = new ArrayCollection();
        $this->profiles = new ArrayCollection();
    }

    /**
     * Add profile
     *
     * @param \AppBundle\Entity\Profile $profile
     *
     * @return Company
     */
    public function addProfile(\AppBundle\Entity\Profile $profile)
    {
        $this->profiles[] = $profile;

        return $this;
    }

    /**
     * Remove profile
     *
     * @param \AppBundle\Entity\Profile $profile
     */
    public function removeProfile(\AppBundle\Entity\Profile $profile)
    {
        $this->profiles->removeElement($profile);
    }

    /**
     * Get profiles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProfiles()
    {
        return $this->profiles;
    }

    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Company
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
