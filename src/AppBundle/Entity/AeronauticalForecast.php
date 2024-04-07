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
 * AeronauticalForecast Entity
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AeronauticalForecastRepository")
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class AeronauticalForecast
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\SerializedName("id")
     * @JMS\Groups({"aeronautical_forecast_detail","aeronautical_forecast_list"})
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     * @JMS\SerializedName("date")
     * @JMS\Groups({"aeronautical_forecast_detail"})
     * @Assert\NotNull()
     */
    private $dateObject;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @JMS\SerializedName("emission_date")
     * @JMS\Groups({"aeronautical_forecast_detail"})
     * @Assert\NotNull()
     */
    private $emissionDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @JMS\SerializedName("validity_date")
     * @JMS\Groups({"aeronautical_forecast_detail"})
     * @Assert\NotNull()
     */
    private $validityDate;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("code")
     * @JMS\Groups({"aeronautical_forecast_detail"})
     */
    private $code;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     * @JMS\SerializedName("synoptic_situation")
     * @JMS\Groups({"aeronautical_forecast_detail"})
     */
    private $synopticSituation;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("observations")
     * @JMS\Groups({"aeronautical_forecast_detail"})
     */
    private $observations;

    /**
     * @var float|null
     *
     * @ORM\Column(type="float", nullable=true)
     * @JMS\SerializedName("maximum_temperature")
     * @JMS\Groups({"aeronautical_forecast_detail"})
     */
    private $maximumTemperature;

    /**
     * @var float|null
     *
     * @ORM\Column(type="float", nullable=true)
     * @JMS\SerializedName("minimum_temperature")
     * @JMS\Groups({"aeronautical_forecast_detail"})
     */
    private $minimumTemperature;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     * @JMS\SerializedName("wind_summary")
     * @JMS\Groups({"aeronautical_forecast_detail"})
     */
    private $windSummary;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("operating_estimate")
     * @JMS\Groups({"aeronautical_forecast_detail"})
     */
    private $operatingEstimate;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("synoptic_situation_route")
     * @JMS\Groups({"aeronautical_forecast_detail"})
     */
    private $synopticSituationRoute;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("santiago_pelambres_route")
     * @JMS\Groups({"aeronautical_forecast_detail"})
     */
    private $santiagoPelambresRoute;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("serena_pelambres_route")
     * @JMS\Groups({"aeronautical_forecast_detail"})
     */
    private $serenaPelambresRoute;

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
     * Set emissionDate.
     *
     * @param \DateTime $emissionDate
     *
     * @return AeronauticalForecast
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
     * @return AeronauticalForecast
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
     * Set code.
     *
     * @param string|null $code
     *
     * @return AeronauticalForecast
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
     * Set synopticSituation.
     *
     * @param string|null $synopticSituation
     *
     * @return AeronauticalForecast
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
     * Set observations.
     *
     * @param string|null $observations
     *
     * @return AeronauticalForecast
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

    /**
     * Set maximumTemperature.
     *
     * @param float|null $maximumTemperature
     *
     * @return AeronauticalForecast
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
     * @return AeronauticalForecast
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
     * Set windSummary.
     *
     * @param string|null $windSummary
     *
     * @return AeronauticalForecast
     */
    public function setWindSummary($windSummary = null)
    {
        $this->windSummary = $windSummary;

        return $this;
    }

    /**
     * Get windSummary.
     *
     * @return string|null
     */
    public function getWindSummary()
    {
        return $this->windSummary;
    }

    /**
     * Set operatingEstimate.
     *
     * @param string|null $operatingEstimate
     *
     * @return AeronauticalForecast
     */
    public function setOperatingEstimate($operatingEstimate = null)
    {
        $this->operatingEstimate = $operatingEstimate;

        return $this;
    }

    /**
     * Get operatingEstimate.
     *
     * @return string|null
     */
    public function getOperatingEstimate()
    {
        return $this->operatingEstimate;
    }

    /**
     * Set synopticSituationRoute.
     *
     * @param string|null $synopticSituationRoute
     *
     * @return AeronauticalForecast
     */
    public function setSynopticSituationRoute($synopticSituationRoute = null)
    {
        $this->synopticSituationRoute = $synopticSituationRoute;

        return $this;
    }

    /**
     * Get synopticSituationRoute.
     *
     * @return string|null
     */
    public function getSynopticSituationRoute()
    {
        return $this->synopticSituationRoute;
    }

    /**
     * Set santiagoPelambresRoute.
     *
     * @param string|null $santiagoPelambresRoute
     *
     * @return AeronauticalForecast
     */
    public function setSantiagoPelambresRoute($santiagoPelambresRoute = null)
    {
        $this->santiagoPelambresRoute = $santiagoPelambresRoute;

        return $this;
    }

    /**
     * Get santiagoPelambresRoute.
     *
     * @return string|null
     */
    public function getSantiagoPelambresRoute()
    {
        return $this->santiagoPelambresRoute;
    }

    /**
     * Set serenaPelambresRoute.
     *
     * @param string|null $serenaPelambresRoute
     *
     * @return AeronauticalForecast
     */
    public function setSerenaPelambresRoute($serenaPelambresRoute = null)
    {
        $this->serenaPelambresRoute = $serenaPelambresRoute;

        return $this;
    }

    /**
     * Get serenaPelambresRoute.
     *
     * @return string|null
     */
    public function getSerenaPelambresRoute()
    {
        return $this->serenaPelambresRoute;
    }

    /**
     * Set dateObject.
     *
     * @param \DateTime $dateObject
     *
     * @return AeronauticalForecast
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
