<?php

namespace AppBundle\Entity;

use AppBundle\Traits\BlameableEntityAssociation;
use AppBundle\Validator\Constraints as AppAssert;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RisksControls.
 *
 * @ORM\Table(name="risks_controls", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="RISKS_CONTROLS_UNIQUE_KEY_MINE_TYPE_SPECIFIC", columns={"type", "mine_id", "_specific"})
 * })
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RisksControlsRepository")
 * @UniqueEntity(
 *      fields={"type", "mine", "specific"},
 *      errorPath="type",
 *      message="Ya existe este tipo para esta mina."
 * )
 * @AppAssert\ThresholdType()
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class RisksControls
{
    const GUSTS_OF_WIND_KM_HR = 'gusts_of_wind_km_hr';
    const SNOW_FALL = 'snow_fall';
    const LOW_HUMIDITY = 'low_humidity';
    const LOW_TEMPERATURES = 'low_temperatures';
    const HIGH_PROBABILITY_RAIN = 'high_probability_rain';
    const HIGH_PROBABILITY_SNOW = 'high_probability_snow';
    const HIGH_PROBABILITY_THUNDERSTORM = 'high_probability_thunderstorm';
    const SOIL_FREEZING = 'soil_freezing';

    const SOIL_FREEZING_YES_LABEL = 'SI';
    const SOIL_FREEZING_NO_LABEL = 'NO';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\SerializedName("id")
     * @JMS\Groups({"risks_controls_list","risks_controls_detail"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     * @JMS\SerializedName("type")
     * @JMS\Groups({"risks_controls_list","risks_controls_detail"})
     * @Assert\NotNull()
     */
    private $type;

    /**
     * @var bool
     *
     * @ORM\Column(name="_specific", type="boolean", options={"default": 0})
     * @JMS\SerializedName("specific")
     * @JMS\Groups({"risks_controls_list","risks_controls_detail"})
     * @Assert\NotNull()
     */
    private $specific = false;

    /**
     * @var string
     *
     * @ORM\Column(name="threshold", type="string")
     * @JMS\SerializedName("threshold")
     * @JMS\Groups({"risks_controls_detail"})
     * @Assert\NotBlank()
     */
    private $threshold;

    /**
     * @var array|null
     *
     * @ORM\Column(name="risks", type="json_array", nullable=true)
     * @JMS\SerializedName("risks")
     * @JMS\Groups({"risks_controls_detail"})
     */
    private $risks;

    /**
     * @var array|null
     *
     * @ORM\Column(name="controls", type="json_array", nullable=true)
     * @JMS\SerializedName("controls")
     * @JMS\Groups({"risks_controls_detail"})
     */
    private $controls;

    /**
     * @ORM\ManyToOne(targetEntity="Mine")
     * @ORM\JoinColumn(nullable=true)
     * @JMS\SerializedName("mine")
     * @JMS\Groups({"r_risks_controls_mine"})
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
     * constructor.
     */
    public function __construct(Mine $mine = null, bool $specific = false)
    {
        $this->mine = $mine;
        $this->specific = $specific;
    }

    public function __toString()
    {
        return "{$this->mine->getName()} {$this->getTypeLabel()}";
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
     * Set type.
     *
     * @param string $type
     *
     * @return self
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

    /**
     * Set threshold.
     *
     * @param string $threshold
     *
     * @return self
     */
    public function setThreshold($threshold)
    {
        $this->threshold = $threshold;

        return $this;
    }

    /**
     * Get threshold.
     *
     * @return string
     */
    public function getThreshold()
    {
        return $this->threshold;
    }

    /**
     * Set risks.
     *
     * @param array|null $risks
     *
     * @return self
     */
    public function setRisks($risks = null)
    {
        $this->risks = array_values($risks);

        return $this;
    }

    /**
     * Get risks.
     *
     * @return array|null
     */
    public function getRisks()
    {
        return $this->risks;
    }

    /**
     * Set controls.
     *
     * @param array|null $controls
     *
     * @return self
     */
    public function setControls($controls = null)
    {
        $this->controls = array_values($controls);

        return $this;
    }

    /**
     * Get controls.
     *
     * @return array|null
     */
    public function getControls()
    {
        return $this->controls;
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
     * @return array
     */
    public static function getTypes()
    {
        return [
            self::GUSTS_OF_WIND_KM_HR => 'Racha de viento (Km/h)',
            self::LOW_HUMIDITY => 'Baja humedad',
            self::LOW_TEMPERATURES => 'Baja temperaturas',
            self::SNOW_FALL => 'Caida de nieve',
            self::HIGH_PROBABILITY_RAIN => 'Alta probabilidad de lluvia',
            self::HIGH_PROBABILITY_SNOW => 'Alta probabilidad de nieve',
            self::HIGH_PROBABILITY_THUNDERSTORM => 'Alta probabilidad de tormenta eléctrica',
            self::SOIL_FREEZING => 'Suelos congelados',
        ];
    }

    /**
     * get type label.
     *
     * @JMS\VirtualProperty()
     * @JMS\SerializedName("type_label")
     * @JMS\Groups({"risks_controls_detail"})
     *
     * @return string
     */
    public function getTypeLabel()
    {
        $temp = $this->getTypes();

        return $temp[$this->type];
    }

    /**
     * get mine slug.
     *
     * @JMS\VirtualProperty()
     * @JMS\SerializedName("mine_slug")
     * @JMS\Groups({"risks_controls_detail"})
     *
     * @return string
     */
    public function getMineSlug()
    {
        return $this->mine->getSlug();
    }

    /**
     * Get the value of specific.
     *
     * @return bool
     */
    public function getSpecific()
    {
        return $this->specific;
    }

    /**
     * Set the value of specific.
     *
     * @return self
     */
    public function setSpecific(bool $specific)
    {
        $this->specific = $specific;

        return $this;
    }
}
