<?php

namespace AppBundle\Entity;

use AppBundle\Traits\BlameableEntityAssociation;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Link Entity.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LinkRepository")
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class Link
{
    const TYPE_METEOROLOGY = 'meteorology';
    const TYPE_CLIMATOLOGY = 'climatology';
    const TYPE_OTHER = 'other';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\SerializedName("id")
     * @JMS\Groups({"link_detail","link_list"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @JMS\SerializedName("name")
     * @JMS\Groups({"link_detail","link_list"})
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @JMS\SerializedName("url")
     * @JMS\Groups({"link_detail"})
     * @Assert\NotBlank()
     */
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity="Mine")
     * @ORM\JoinColumn(nullable=true)
     *
     * @var Mine
     */
    private $mine;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false, options={"default": "meteorology"})
     * @Assert\NotBlank()
     */
    private $type;

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

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Link
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set url.
     *
     * @param string $url
     *
     * @return Link
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
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

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return Link
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    public static function typeChoices()
    {
        return [
            'Meteorológicos' => self::TYPE_METEOROLOGY,
            'Climatológicos' => self::TYPE_CLIMATOLOGY,
            'Otros' => self::TYPE_OTHER,
        ];
    }

    public function getTypeName()
    {
        $map = array_flip(self::typeChoices());

        return isset($map[$this->getType()]) ? $map[$this->getType()] : null;
    }
}
