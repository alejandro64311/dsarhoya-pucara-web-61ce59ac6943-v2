<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use AppBundle\Traits\BlameableEntityAssociation;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Road Entity.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RoadRepository")
 * @ORM\Table(uniqueConstraints={
 *      @ORM\UniqueConstraint(name="RoadIndex", columns={"name", "date_object"})
 * })
 * @UniqueEntity(
 *      fields={"name", "dateObject", "mine"},
 *      errorPath="name",
 *      message="Ya existe un pronóstico para este camino y fecha."
 * )
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class Road
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\SerializedName("id")
     * @JMS\Groups({"road_detail","road_list"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @JMS\SerializedName("name")
     * @JMS\Groups({"road_detail","road_list"})
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     * @JMS\SerializedName("date")
     * @JMS\Groups({"road_detail","road_list"})
     * @Assert\NotNull()
     */
    private $dateObject;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @JMS\SerializedName("emission_date")
     * @JMS\Groups({"road_detail"})
     * @Assert\NotNull()
     */
    private $emissionDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @JMS\SerializedName("validity_date")
     * @JMS\Groups({"road_detail"})
     * @Assert\NotNull()
     */
    private $validityDate;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("transit")
     * @JMS\Groups({"road_detail"})
     */
    private $transit;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dsy_index", type="string", nullable=true)
     * @JMS\SerializedName("index")
     * @JMS\Groups({"road_detail"})
     */
    private $index;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("risk")
     * @JMS\Groups({"road_detail"})
     */
    private $risk;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dsy_condition", type="string", nullable=true)
     * @JMS\SerializedName("condition")
     * @JMS\Groups({"road_detail"})
     */
    private $condition;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("alert")
     * @JMS\Groups({"road_detail"})
     */
    private $alert;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("observations")
     * @JMS\Groups({"road_detail"})
     */
    private $observations;

    /**
     * @ORM\ManyToOne(targetEntity="Mine")
     * @ORM\JoinColumn(nullable=true)
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

    /**
     * Constructor.
     *
     * @param int $date
     */
    public function __construct(string $name = null, \DateTime $date = null)
    {
        $this->name = $name;
        $this->dateObject = $date;
    }

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
     * @return Road
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
     * Set transit.
     *
     * @param string|null $transit
     *
     * @return Road
     */
    public function setTransit($transit)
    {
        $this->transit = $transit;

        return $this;
    }

    /**
     * Get transit.
     *
     * @return string|null
     */
    public function getTransit()
    {
        return $this->transit;
    }

    /**
     * Set index.
     *
     * @param string|null $index
     *
     * @return Road
     */
    public function setIndex($index = null)
    {
        $this->index = $index;

        return $this;
    }

    /**
     * Get index.
     *
     * @return string|null
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Set risk.
     *
     * @param string|null $risk
     *
     * @return Road
     */
    public function setRisk($risk = null)
    {
        $this->risk = $risk;

        return $this;
    }

    /**
     * Get risk.
     *
     * @return string|null
     */
    public function getRisk()
    {
        return $this->risk;
    }

    /**
     * Set condition.
     *
     * @param string|null $condition
     *
     * @return Road
     */
    public function setCondition($condition = null)
    {
        $this->condition = $condition;

        return $this;
    }

    /**
     * Get condition.
     *
     * @return string|null
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * Set alert.
     *
     * @param string|null $alert
     *
     * @return Road
     */
    public function setAlert($alert = null)
    {
        $this->alert = $alert;

        return $this;
    }

    /**
     * Get alert.
     *
     * @return string|null
     */
    public function getAlert()
    {
        return $this->alert;
    }

    /**
     * Set emissionDate.
     *
     * @param \DateTime $emissionDate
     *
     * @return Road
     */
    public function setEmissionDate($emissionDate)
    {
        $this->emissionDate = $emissionDate;

        return $this;
    }

    /**
     * Get emissionDate.
     *
     * @return \DateTime
     */
    public function getEmissionDate()
    {
        return $this->emissionDate;
    }

    /**
     * Set validityDate.
     *
     * @param \DateTime|null $validityDate
     *
     * @return Road
     */
    public function setValidityDate($validityDate = null)
    {
        $this->validityDate = $validityDate;

        return $this;
    }

    /**
     * Get validityDate.
     *
     * @return \DateTime|null
     */
    public function getValidityDate()
    {
        return $this->validityDate;
    }

    /**
     * Set dateObject.
     *
     * @param \DateTime $dateObject
     *
     * @return Road
     */
    public function setDateObject($dateObject)
    {
        $this->dateObject = $dateObject;

        return $this;
    }

    /**
     * Get dateObject.
     *
     * @return \DateTime
     */
    public function getDateObject()
    {
        return $this->dateObject;
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
     * @param Mine $mine
     *
     * @return self
     */
    public function setMine(Mine $mine)
    {
        $this->mine = $mine;

        return $this;
    }

    /**
     * Set observations.
     *
     * @param string|null $observations
     *
     * @return Road
     */
    public function setObservations($observations = null)
    {
        $this->observations = $observations;

        return $this;
    }

    /**
     * Get observations.
     *
     * @return string|null
     */
    public function getObservations()
    {
        return $this->observations;
    }
}
