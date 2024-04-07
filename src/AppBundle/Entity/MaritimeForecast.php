<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use AppBundle\Traits\BlameableEntityAssociation;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * MaritimeForecast Entity
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MaritimeForecastRepository")
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class MaritimeForecast
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\SerializedName("id")
     * @JMS\Groups({"maritime_forecast_detail","maritime_forecast_list"})
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     * @JMS\SerializedName("date")
     * @JMS\Groups({"maritime_forecast_detail"})
     * @Assert\NotNull()
     */
    private $dateObject;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("code")
     * @JMS\Groups({"maritime_forecast_detail","maritime_forecast_list"})
     */
    private $code;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @JMS\SerializedName("emission_date")
     * @JMS\Groups({"maritime_forecast_detail"})
     * @Assert\NotNull()
     */
    private $emissionDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @JMS\SerializedName("validity_date")
     * @JMS\Groups({"maritime_forecast_detail"})
     * @Assert\NotNull()
     */
    private $validityDate;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     * @JMS\SerializedName("synoptic_situation")
     * @JMS\Groups({"maritime_forecast_detail"})
     */
    private $synopticSituation;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("forecast")
     * @JMS\Groups({"maritime_forecast_detail"})
     */
    private $forecast;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("sea_state")
     * @JMS\Groups({"maritime_forecast_detail"})
     */
    private $seaState;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     * @JMS\SerializedName("maximum_temperature")
     * @JMS\Groups({"maritime_forecast_detail"})
     */
    private $maximumTemperature;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     * @JMS\SerializedName("minimum_temperature")
     * @JMS\Groups({"maritime_forecast_detail"})
     */
    private $minimumTemperature;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("wind_intensity")
     * @JMS\Groups({"maritime_forecast_detail"})
     */
    private $windIntensity;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("wind_direction_am")
     * @JMS\Groups({"maritime_forecast_detail"})
     */
    private $windDirectionAM;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("wind_direction_observation")
     * @JMS\Groups({"maritime_forecast_detail"})
     */
    private $windDirectionObservation;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("height_waves_general")
     * @JMS\Groups({"maritime_forecast_detail"})
     */
    private $heightWavesGeneral;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("height_waves_am")
     * @JMS\Groups({"maritime_forecast_detail"})
     */
    private $heightWavesAM;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("height_waves_pm")
     * @JMS\Groups({"maritime_forecast_detail"})
     */
    private $heightWavesPM;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("speed_waves_am")
     * @JMS\Groups({"maritime_forecast_detail"})
     */
    private $speedWavesAM;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("speed_waves_pm")
     * @JMS\Groups({"maritime_forecast_detail"})
     */
    private $speedWavesPM;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("wind_direction_pm")
     * @JMS\Groups({"maritime_forecast_detail"})
     */
    private $windDirectionPM;

    /**
     * @ORM\ManyToOne(targetEntity="Mine")
     * @ORM\JoinColumn(nullable=true)
     *
     * @var Mine
     */
    private $mine;

    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    /**
     * Hook blameable behavior
     * updates createdBy, updatedBy fields
     */
    use BlameableEntityAssociation;

    /**
     * Constructor
     *
     * @param integer $date
     */
    public function __construct(\DateTime $date = null)
    {
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
     * Set code.
     *
     * @param string|null $code
     *
     * @return MaritimeForecast
     */
    public function setCode($code = null)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code.
     *
     * @return string|null
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set emissionDate.
     *
     * @param \DateTime $emissionDate
     *
     * @return MaritimeForecast
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
     * @return MaritimeForecast
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
     * Set synopticSituation.
     *
     * @param string|null $synopticSituation
     *
     * @return MaritimeForecast
     */
    public function setSynopticSituation($synopticSituation = null)
    {
        $this->synopticSituation = $synopticSituation;

        return $this;
    }

    /**
     * Get synopticSituation.
     *
     * @return string|null
     */
    public function getSynopticSituation()
    {
        return $this->synopticSituation;
    }

    /**
     * Set forecast.
     *
     * @param string|null $forecast
     *
     * @return MaritimeForecast
     */
    public function setForecast($forecast = null)
    {
        $this->forecast = $forecast;

        return $this;
    }

    /**
     * Get forecast.
     *
     * @return string|null
     */
    public function getForecast()
    {
        return $this->forecast;
    }

    /**
     * Set seaState.
     *
     * @param string|null $seaState
     *
     * @return MaritimeForecast
     */
    public function setSeaState($seaState = null)
    {
        $this->seaState = $seaState;

        return $this;
    }

    /**
     * Get seaState.
     *
     * @return string|null
     */
    public function getSeaState()
    {
        return $this->seaState;
    }

    /**
     * Set maximumTemperature.
     *
     * @param float|null $maximumTemperature
     *
     * @return MaritimeForecast
     */
    public function setMaximumTemperature($maximumTemperature = null)
    {
        $this->maximumTemperature = $maximumTemperature;

        return $this;
    }

    /**
     * Get maximumTemperature.
     *
     * @return float|null
     */
    public function getMaximumTemperature()
    {
        return $this->maximumTemperature;
    }

    /**
     * Set minimumTemperature.
     *
     * @param float|null $minimumTemperature
     *
     * @return MaritimeForecast
     */
    public function setMinimumTemperature($minimumTemperature = null)
    {
        $this->minimumTemperature = $minimumTemperature;

        return $this;
    }

    /**
     * Get minimumTemperature.
     *
     * @return float|null
     */
    public function getMinimumTemperature()
    {
        return $this->minimumTemperature;
    }

    /**
     * Set windIntensity.
     *
     * @param string|null $windIntensity
     *
     * @return MaritimeForecast
     */
    public function setWindIntensity($windIntensity = null)
    {
        $this->windIntensity = $windIntensity;

        return $this;
    }

    /**
     * Get windIntensity.
     *
     * @return string|null
     */
    public function getWindIntensity()
    {
        return $this->windIntensity;
    }

    /**
     * Set windDirectionAM.
     *
     * @param string|null $windDirectionAM
     *
     * @return MaritimeForecast
     */
    public function setWindDirectionAM($windDirectionAM = null)
    {
        $this->windDirectionAM = $windDirectionAM;

        return $this;
    }

    /**
     * Get windDirectionAM.
     *
     * @return string|null
     */
    public function getWindDirectionAM()
    {
        return $this->windDirectionAM;
    }

    /**
     * Set windDirectionObservation.
     *
     * @param string|null $windDirectionObservation
     *
     * @return MaritimeForecast
     */
    public function setWindDirectionObservation($windDirectionObservation = null)
    {
        $this->windDirectionObservation = $windDirectionObservation;

        return $this;
    }

    /**
     * Get windDirectionObservation.
     *
     * @return string|null
     */
    public function getWindDirectionObservation()
    {
        return $this->windDirectionObservation;
    }

    /**
     * Set heightWavesGeneral.
     *
     * @param string|null $heightWavesGeneral
     *
     * @return MaritimeForecast
     */
    public function setHeightWavesGeneral($heightWavesGeneral = null)
    {
        $this->heightWavesGeneral = $heightWavesGeneral;

        return $this;
    }

    /**
     * Get heightWavesGeneral.
     *
     * @return string|null
     */
    public function getHeightWavesGeneral()
    {
        return $this->heightWavesGeneral;
    }

    /**
     * Set heightWavesAM.
     *
     * @param string|null $heightWavesAM
     *
     * @return MaritimeForecast
     */
    public function setHeightWavesAM($heightWavesAM = null)
    {
        $this->heightWavesAM = $heightWavesAM;

        return $this;
    }

    /**
     * Get heightWavesAM.
     *
     * @return string|null
     */
    public function getHeightWavesAM()
    {
        return $this->heightWavesAM;
    }

    /**
     * Set heightWavesPM.
     *
     * @param string|null $heightWavesPM
     *
     * @return MaritimeForecast
     */
    public function setHeightWavesPM($heightWavesPM = null)
    {
        $this->heightWavesPM = $heightWavesPM;

        return $this;
    }

    /**
     * Get heightWavesPM.
     *
     * @return string|null
     */
    public function getHeightWavesPM()
    {
        return $this->heightWavesPM;
    }

    /**
     * Set speedWavesAM.
     *
     * @param string|null $speedWavesAM
     *
     * @return MaritimeForecast
     */
    public function setSpeedWavesAM($speedWavesAM = null)
    {
        $this->speedWavesAM = $speedWavesAM;

        return $this;
    }

    /**
     * Get speedWavesAM.
     *
     * @return string|null
     */
    public function getSpeedWavesAM()
    {
        return $this->speedWavesAM;
    }

    /**
     * Set speedWavesPM.
     *
     * @param string|null $speedWavesPM
     *
     * @return MaritimeForecast
     */
    public function setSpeedWavesPM($speedWavesPM = null)
    {
        $this->speedWavesPM = $speedWavesPM;

        return $this;
    }

    /**
     * Get speedWavesPM.
     *
     * @return string|null
     */
    public function getSpeedWavesPM()
    {
        return $this->speedWavesPM;
    }

    /**
     * Set windDirectionPM.
     *
     * @param string|null $windDirectionPM
     *
     * @return MaritimeForecast
     */
    public function setWindDirectionPM($windDirectionPM = null)
    {
        $this->windDirectionPM = $windDirectionPM;

        return $this;
    }

    /**
     * Get windDirectionPM.
     *
     * @return string|null
     */
    public function getWindDirectionPM()
    {
        return $this->windDirectionPM;
    }

    /**
     * Set dateObject.
     *
     * @param \DateTime $dateObject
     *
     * @return MaritimeForecast
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
     * Get the value of mine
     *
     * @return  Mine
     */ 
    public function getMine()
    {
        return $this->mine;
    }

    /**
     * Set the value of mine
     *
     * @param  Mine  $mine
     *
     * @return  self
     */ 
    public function setMine(Mine $mine)
    {
        $this->mine = $mine;

        return $this;
    }
}
