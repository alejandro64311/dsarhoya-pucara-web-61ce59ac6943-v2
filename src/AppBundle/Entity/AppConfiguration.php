<?php

namespace AppBundle\Entity;

use AppBundle\Traits\BlameableEntityAssociation;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AppConfigurationRepository")
 * @UniqueEntity(
 *      fields={"mine"},
 *      errorPath="mine",
 *      message="Ya existe una configuración para esta mina."
 * )
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class AppConfiguration
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @JMS\SerializedName("home_header_text")
     * @JMS\Groups({"app_configuration_detail"})
     */
    private $homeHeaderText;

    /**
     * @ORM\ManyToOne(targetEntity="Mine")
     * @ORM\JoinColumn(nullable=true)
     * @JMS\SerializedName("mine")
     * @JMS\Groups({"r_app_configuration_mine"})
     *
     * @var Mine
     */
    private $mine;

    /*
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    /*
     * Hook blameable behavior
     * updates createdBy, updatedBy fields
     */
    use BlameableEntityAssociation;

    public function __construct(Mine $mine)
    {
        $this->mine = $mine;
    }

    /**
     * Get the value of id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of homeHeaderText.
     *
     * @return string
     */
    public function getHomeHeaderText()
    {
        return $this->homeHeaderText;
    }

    /**
     * Set the value of homeHeaderText.
     *
     * @return self
     */
    public function setHomeHeaderText(string $homeHeaderText)
    {
        $this->homeHeaderText = $homeHeaderText;

        return $this;
    }

    /**
     * Get the value of mine.
     *
     * @return Mine
     */
    public function getMine()
    {
        return $this->mine;
    }

    /**
     * Set the value of mine.
     *
     * @return self
     */
    public function setMine(Mine $mine)
    {
        $this->mine = $mine;

        return $this;
    }

    // /**
    //  * get mine slug.
    //  *
    //  * @JMS\VirtualProperty()
    //  * @JMS\SerializedName("mine_slug")
    //  * @JMS\Groups({"app_configuration_detail"})
    //  *
    //  * @return string
    //  */
    // public function getMineSlug()
    // {
    //     return $this->mine->getSlug();
    // }
}
