<?php

namespace AppBundle\Entity;

use AppBundle\Traits\BlameableEntityAssociation;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * HourMeteorologicalForecast Entity.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HourMeteorologicalForecastRepository")
 * @ORM\Table(uniqueConstraints={
 *      @ORM\UniqueConstraint(name="HourMeteorologicalForecastIndex", columns={"place", "date", "mine_id"})
 * })
 * @UniqueEntity(
 *      fields={"place", "date", "mine"},
 *      errorPath="place",
 *      message="Ya existe un pronóstico para este lugar y fecha."
 * )
 *
 * @author jcordova <jhonny.cordova@dsarhoya.cl>
 */
class HourMeteorologicalForecast
{
    // Weather types
    const WEATHER_TYPE_CLEAR_SKY = 'soleado';
    const WEATHER_TYPE_FEW_CLOUDS = 'parcialmente nublado';
    const WEATHER_TYPE_SCATTERED_CLOUDS = 'nublado';
    const WEATHER_TYPE_SHOWER_RAIN = 'chubascos';
    const WEATHER_TYPE_RAIN = 'lluvia';
    const WEATHER_TYPE_THUNDERSTORM = 'tormenta';
    const WEATHER_TYPE_SNOW = 'nieve';
    const WEATHER_TYPE_MIST = 'niebla';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $place;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Assert\NotNull()
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $cloudCoverIcon;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $windDirection;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $windIntensity;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $windGusts;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $temperature;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $thermalSensation;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $relativeHumidity;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $precipitationProbability;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $estimatedAccumulation;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $electricalActivityProbability;

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
     * Get the value of date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date.
     *
     * @return self
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of cloudCoverIcon.
     *
     * @return string
     */
    public function getCloudCoverIcon()
    {
        return $this->cloudCoverIcon;
    }

    /**
     * Set the value of cloudCoverIcon.
     *
     * @return self
     */
    public function setCloudCoverIcon(string $cloudCoverIcon)
    {
        $this->cloudCoverIcon = $cloudCoverIcon;

        return $this;
    }

    /**
     * Get the value of windDirection.
     *
     * @return string
     */
    public function getWindDirection()
    {
        return $this->windDirection;
    }

    /**
     * Set the value of windDirection.
     *
     * @return self
     */
    public function setWindDirection(string $windDirection)
    {
        $this->windDirection = $windDirection;

        return $this;
    }

    /**
     * Get the value of windIntensity.
     *
     * @return string
     */
    public function getWindIntensity()
    {
        return $this->windIntensity;
    }

    /**
     * Set the value of windIntensity.
     *
     * @return self
     */
    public function setWindIntensity(string $windIntensity)
    {
        $this->windIntensity = $windIntensity;

        return $this;
    }

    /**
     * Get the value of windGusts.
     *
     * @return string
     */
    public function getWindGusts()
    {
        return $this->windGusts;
    }

    /**
     * Set the value of windGusts.
     *
     * @return self
     */
    public function setWindGusts(string $windGusts)
    {
        $this->windGusts = $windGusts;

        return $this;
    }

    /**
     * Get the value of temperature.
     *
     * @return string
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * Set the value of temperature.
     *
     * @return self
     */
    public function setTemperature(string $temperature)
    {
        $this->temperature = $temperature;

        return $this;
    }

    /**
     * Get the value of thermalSensation.
     *
     * @return string
     */
    public function getThermalSensation()
    {
        return $this->thermalSensation;
    }

    /**
     * Set the value of thermalSensation.
     *
     * @return self
     */
    public function setThermalSensation(string $thermalSensation)
    {
        $this->thermalSensation = $thermalSensation;

        return $this;
    }

    /**
     * Get the value of relativeHumidity.
     *
     * @return string
     */
    public function getRelativeHumidity()
    {
        return $this->relativeHumidity;
    }

    /**
     * Set the value of relativeHumidity.
     *
     * @return self
     */
    public function setRelativeHumidity(string $relativeHumidity)
    {
        $this->relativeHumidity = $relativeHumidity;

        return $this;
    }

    /**
     * Get the value of precipitationProbability.
     *
     * @return string
     */
    public function getPrecipitationProbability()
    {
        return $this->precipitationProbability;
    }

    /**
     * Set the value of precipitationProbability.
     *
     * @return self
     */
    public function setPrecipitationProbability(string $precipitationProbability)
    {
        $this->precipitationProbability = $precipitationProbability;

        return $this;
    }

    /**
     * Get the value of estimatedAccumulation.
     *
     * @return string
     */
    public function getEstimatedAccumulation()
    {
        return $this->estimatedAccumulation;
    }

    /**
     * Set the value of estimatedAccumulation.
     *
     * @return self
     */
    public function setEstimatedAccumulation(string $estimatedAccumulation)
    {
        $this->estimatedAccumulation = $estimatedAccumulation;

        return $this;
    }

    /**
     * Get the value of electricalActivityProbability.
     *
     * @return string
     */
    public function getElectricalActivityProbability()
    {
        return $this->electricalActivityProbability;
    }

    /**
     * Set the value of electricalActivityProbability.
     *
     * @return self
     */
    public function setElectricalActivityProbability(string $electricalActivityProbability)
    {
        $this->electricalActivityProbability = $electricalActivityProbability;

        return $this;
    }

    /**
     * Get the value of place.
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set the value of place.
     *
     * @return self
     */
    public function setPlace(string $place)
    {
        $this->place = $place;

        return $this;
    }

    public function getDayFormatted()
    {
        $months = [
            'January' => 'Enero',
            'February' => 'Febrero',
            'March' => 'Marzo',
            'April' => 'Abril',
            'May' => 'Mayo',
            'June' => 'Junio',
            'July' => 'Julio',
            'August' => 'Agosto',
            'September' => 'Septiembre',
            'October' => 'Octubre',
            'November' => 'Noviembre',
            'December' => 'Diciembre',
        ];

        return $this->date->format('d').' de '.$months[$this->date->format('F')];
    }

    public function getHourFormatted()
    {
        return $this->date->format('H').' horas ';
    }
}
