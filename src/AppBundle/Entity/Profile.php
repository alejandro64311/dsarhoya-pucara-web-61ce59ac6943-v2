<?php 

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use dsarhoya\BaseBundle\Entity\BaseProfile;
use dsarhoya\BaseBundle\Entity\BaseProfileInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Profile
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProfileRepository")
 */
class Profile extends BaseProfile implements BaseProfileInterface
{
    /**
     * @var \AppBundle\Entity\Company
     *
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="profiles")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $company;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="User", mappedBy="profile")
     */
    private $users;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Action", inversedBy="profiles")
     * @ORM\JoinTable(name="permissions",
     *      joinColumns={
     *          @ORM\JoinColumn(name="profile_id", referencedColumnName="id")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="action_id", referencedColumnName="id")
     *      }
     * )
     */
    private $actions;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->actions = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    /**
     * Set company.
     *
     * @param \AppBundle\Entity\Company|null $company
     *
     * @return Profile
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
     * Add user.
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Profile
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        if ($this->users->contains($user)) {
            return $this;
        }
        $this->users[] = $user;
        $user->setProfile($this);

        return $this;
    }

    /**
     * Remove user.
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        return $this->users->removeElement($user);
    }

    /**
     * Get users.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add action.
     *
     * @param \AppBundle\Entity\Action $action
     *
     * @return Profile
     */
    public function addAction(\AppBundle\Entity\Action $action)
    {
        if ($this->action->contains($action)) {
            return $this;
        }
        $this->actions[] = $action;

        return $this;
    }

    /**
     * Remove action.
     *
     * @param \AppBundle\Entity\Action $action
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeAction(\AppBundle\Entity\Action $action)
    {
        return $this->actions->removeElement($action);
    }

    /**
     * Get actions.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
