<?php 

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use dsarhoya\BaseBundle\Entity\BaseAction;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Action
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ActionRepository")
 */
class Action extends BaseAction
{
    /**
     * @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\ManyToMany(targetEntity="Profile", mappedBy="actions")
     */
    private $profiles;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->profiles = new ArrayCollection();
    }

    /**
     * Add profile.
     *
     * @param \AppBundle\Entity\Profile $profile
     *
     * @return Action
     */
    public function addProfile(\AppBundle\Entity\Profile $profile)
    {
        $this->profiles[] = $profile;

        return $this;
    }

    /**
     * Remove profile.
     *
     * @param \AppBundle\Entity\Profile $profile
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeProfile(\AppBundle\Entity\Profile $profile)
    {
        return $this->profiles->removeElement($profile);
    }

    /**
     * Get profiles.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProfiles()
    {
        return $this->profiles;
    }
}
