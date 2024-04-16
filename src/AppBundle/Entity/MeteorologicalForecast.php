<?php

namespace AppBundle\Entity;

use AppBundle\Traits\BlameableEntityAssociation;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MeteorologicalForecast Entity.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MeteorologicalForecastRepository")
 * @ORM\Table(uniqueConstraints={
 *      @ORM\UniqueConstraint(name="MeteorologicalForecastIndex", columns={"place", "date_object", "mine_id"})
 * })
 * @UniqueEntity(
 *      fields={"place", "dateObject", "mine"},
 *      errorPath="place",
 *      message="Ya existe un pronóstico para este lugar y fecha."
 * )
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class MeteorologicalForecast
{
    const PLACE_MINA_LOS_PELAMBRES = 'pelambres';
    const PLACE_CHACAY = 'chacay';
    const PLACE_VALLE_CHOAPA = 'valle';
    const PLACE_PUERTO_PUNTA_CHUNGO = 'puerto';

    const WIND_UNIT_METERS_BY_SECOND = 'meters_by_second';
    const WIND_UNIT_KNOTS = 'knots';
    const WIND_UNIT_KILOMETERS_BY_HOUR = 'kilometers_by_hour';

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
     * @JMS\SerializedName("id")
     * @JMS\Groups({"forecast_detail","forecast_list"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @JMS\SerializedName("place")
     * @JMS\Groups({"meteorological_forecast_detail","meteorological_forecast_list"})
     * @Assert\NotBlank()
     */
    private $place;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     * @JMS\SerializedName("date")
     * @JMS\Groups({"meteorological_forecast_detail", "meteorological_forecast_list"})
     * @Assert\NotNull()
     */
    private $dateObject;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @JMS\SerializedName("emission_date")
     * @JMS\Groups({"meteorological_forecast_detail","meteorological_forecast_list"})
     */
    private $emissionDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @JMS\SerializedName("validity_date")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $validityDate;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     * @JMS\SerializedName("synoptic_situation")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $synopticSituation;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("general_weather")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $generalWeather;

    /**
     * @var string
     *
     * @ORM\Column(name="general_weather_icon", type="string", nullable=true)
     */
    private $generalWeatherIcon;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("weather_am")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $weatherAM;

    /**
     * @var string
     *
     * @ORM\Column(name="weather_am_icon", type="string", nullable=true)
     */
    private $weatherAMIcon;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("weather_pm")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $weatherPM;

    /**
     * @var string
     *
     * @ORM\Column(name="weather_pm_icon", type="string", nullable=true)
     */
    private $weatherPMIcon;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     * @JMS\SerializedName("maximum_temperature")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $maximumTemperature;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     * @JMS\SerializedName("minimum_temperature")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $minimumTemperature;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     * @JMS\SerializedName("isotherm")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $isotherm;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("visibility")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $visibility;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("wind_direction_am")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $windDirectionAM;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("wind_direction_pm")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $windDirectionPM;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("maximum_gust_wind")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $maximumGustWind;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotNull(message="La unidad del viento es obligatoria (m/s - nudos)")
     */
    private $windUnid = self::WIND_UNIT_METERS_BY_SECOND;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("uv_radiation")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $uvRadiation;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("uv_radiation_map_url")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $uvRadiationMapUrl;

    /**
     * @var float|null
     *
     * @ORM\Column(type="float", nullable=true)
     * @JMS\SerializedName("rain_last_24_hours")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $rainLast24hours;

    /**
     * @var float|null
     *
     * @ORM\Column(type="float", nullable=true)
     * @JMS\SerializedName("rain_accumulated")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $rainAccumulated;

    /**
     * @var float|null
     *
     * @ORM\Column(type="float", nullable=true)
     * @JMS\SerializedName("rain_normal")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $rainNormal;

    /**
     * @var float|null
     *
     * @ORM\Column(type="float", nullable=true)
     * @JMS\SerializedName("rain_surplus_deficit")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $rainSurplusDeficit;

    /**
     * @var float|null
     *
     * @ORM\Column(type="float", nullable=true)
     * @JMS\SerializedName("rain_probability")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $rainProbability;

    /**
     * @var float|null
     *
     * @ORM\Column(type="float", nullable=true)
     * @JMS\SerializedName("snow_last_24_hours")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $snowLast24hours;

    /**
     * @var float|null
     *
     * @ORM\Column(type="float", nullable=true)
     * @JMS\SerializedName("snow_accumulated")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $snowAccumulated;

    /**
     * @var float|null
     *
     * @ORM\Column(type="float", nullable=true)
     * @JMS\SerializedName("snow_normal")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $snowNormal;

    /**
     * @var float|null
     *
     * @ORM\Column(type="float", nullable=true)
     * @JMS\SerializedName("snow_surplus_deficit")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $snowSurplusDeficit;

    /**
     * @var float|null
     *
     * @ORM\Column(type="float", nullable=true)
     * @JMS\SerializedName("snow_probability")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $snowProbability;

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     * @JMS\SerializedName("satelital_image_url")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $satelitalImageUrl;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("sea_conditions")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $seaConditions;

    /**
     * @ORM\ManyToOne(targetEntity="Mine")
     * @ORM\JoinColumn(nullable=true)
     *
     * @var Mine
     */
    private $mine;

    /**
     * @var float|null
     *
     * @ORM\Column(type="float", nullable=true)
     * @JMS\SerializedName("humidity")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $humidity;

    /**
     * @var float|null
     *
     * @ORM\Column(type="float", nullable=true)
     * @JMS\SerializedName("maximum_humidity")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $maximumHumidity;

    /**
     * @var float|null
     *
     * @ORM\Column(type="float", nullable=true)
     * @JMS\SerializedName("electric_activity")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $electricActivity;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     * @JMS\SerializedName("description")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $soilFreezing;

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

    public function __construct(string $place = null, \DateTime $date = null)
    {
        $this->place = $place;
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
     * Set place.
     *
     * @param string $place
     *
     * @return MeteorologicalForecast
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place.
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set emissionDate.
     *
     * @param \DateTime|null $emissionDate
     *
     * @return MeteorologicalForecast
     */
    public function setEmissionDate($emissionDate)
    {
        $this->emissionDate = $emissionDate;

        return $this;
    }

    /**
     * Get emissionDate.
     *
     * @return \DateTime|null
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
     * @return MeteorologicalForecast
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
     * Set generalWeather.
     *
     * @param string|null $generalWeather
     *
     * @return MeteorologicalForecast
     */
    public function setGeneralWeather($generalWeather = null)
    {
        $this->generalWeather = $generalWeather;

        return $this;
    }

    /**
     * Get generalWeather.
     *
     * @return string|null
     */
    public function getGeneralWeather()
    {
        return $this->generalWeather;
    }

    /**
     * Set synopticSituation.
     *
     * @param string|null $synopticSituation
     *
     * @return MeteorologicalForecast
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
     * Set weatherAM.
     *
     * @param string|null $weatherAM
     *
     * @return MeteorologicalForecast
     */
    public function setWeatherAM($weatherAM = null)
    {
        $this->weatherAM = $weatherAM;

        return $this;
    }

    /**
     * Get weatherAM.
     *
     * @return string|null
     */
    public function getWeatherAM()
    {
        return $this->weatherAM;
    }

    /**
     * Set weatherPM.
     *
     * @param string|null $weatherPM
     *
     * @return MeteorologicalForecast
     */
    public function setWeatherPM($weatherPM = null)
    {
        $this->weatherPM = $weatherPM;

        return $this;
    }

    /**
     * Get weatherPM.
     *
     * @return string|null
     */
    public function getWeatherPM()
    {
        return $this->weatherPM;
    }

    /**
     * Set maximumTemperature.
     *
     * @param float $maximumTemperature
     *
     * @return MeteorologicalForecast
     */
    public function setMaximumTemperature($maximumTemperature)
    {
        $this->maximumTemperature = $maximumTemperature;

        return $this;
    }

    /**
     * Get maximumTemperature.
     *
     * @return float
     */
    public function getMaximumTemperature()
    {
        return $this->maximumTemperature;
    }

    /**
     * Set minimumTemperature.
     *
     * @param float $minimumTemperature
     *
     * @return MeteorologicalForecast
     */
    public function setMinimumTemperature($minimumTemperature)
    {
        $this->minimumTemperature = $minimumTemperature;

        return $this;
    }

    /**
     * Get minimumTemperature.
     *
     * @return float
     */
    public function getMinimumTemperature()
    {
        return $this->minimumTemperature;
    }

    /**
     * Set isotherm.
     *
     * @param float|null $isotherm
     *
     * @return MeteorologicalForecast
     */
    public function setIsotherm($isotherm = null)
    {
        $this->isotherm = $isotherm;

        return $this;
    }

    /**
     * Get isotherm.
     *
     * @return float|null
     */
    public function getIsotherm()
    {
        return $this->isotherm;
    }

    /**
     * Set windDirectionAM.
     *
     * @param string|null $windDirectionAM
     *
     * @return MeteorologicalForecast
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
     * Set windDirectionPM.
     *
     * @param string|null $windDirectionPM
     *
     * @return MeteorologicalForecast
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
     * Set maximumGustWind.
     *
     * @param string|null $maximumGustWind
     *
     * @return MeteorologicalForecast
     */
    public function setMaximumGustWind($maximumGustWind)
    {
        $this->maximumGustWind = $maximumGustWind;

        return $this;
    }

    /**
     * Get maximumGustWind.
     *
     * @return string|null
     */
    public function getMaximumGustWind()
    {
        return $this->maximumGustWind;
    }

    /**
     * Set uvRadiation.
     *
     * @param string|null $uvRadiation
     *
     * @return MeteorologicalForecast
     */
    public function setUvRadiation($uvRadiation = null)
    {
        $this->uvRadiation = $uvRadiation;

        return $this;
    }

    /**
     * Get uvRadiation.
     *
     * @return string|null
     */
    public function getUvRadiation()
    {
        return $this->uvRadiation;
    }

    /**
     * Set uvRadiationMapUrl.
     *
     * @param string|null $uvRadiationMapUrl
     *
     * @return MeteorologicalForecast
     */
    public function setUvRadiationMapUrl($uvRadiationMapUrl = null)
    {
        $this->uvRadiationMapUrl = $uvRadiationMapUrl;

        return $this;
    }

    /**
     * Get uvRadiationMapUrl.
     *
     * @return string|null
     */
    public function getUvRadiationMapUrl()
    {
        return $this->uvRadiationMapUrl;
    }

    /**
     * Set rainLast24hours.
     *
     * @param float|null $rainLast24hours
     *
     * @return MeteorologicalForecast
     */
    public function setRainLast24hours($rainLast24hours = null)
    {
        $this->rainLast24hours = $rainLast24hours;

        return $this;
    }

    /**
     * Get rainLast24hours.
     *
     * @return float|null
     */
    public function getRainLast24hours()
    {
        return $this->rainLast24hours;
    }

    /**
     * Set rainAccumulated.
     *
     * @param float|null $rainAccumulated
     *
     * @return MeteorologicalForecast
     */
    public function setRainAccumulated($rainAccumulated = null)
    {
        $this->rainAccumulated = $rainAccumulated;

        return $this;
    }

    /**
     * Get rainAccumulated.
     *
     * @return float|null
     */
    public function getRainAccumulated()
    {
        return $this->rainAccumulated;
    }

    /**
     * Set rainNormal.
     *
     * @param float|null $rainNormal
     *
     * @return MeteorologicalForecast
     */
    public function setRainNormal($rainNormal = null)
    {
        $this->rainNormal = $rainNormal;

        return $this;
    }

    /**
     * Get rainNormal.
     *
     * @return float|null
     */
    public function getRainNormal()
    {
        return $this->rainNormal;
    }

    /**
     * Set rainSurplusDeficit.
     *
     * @param float|null $rainSurplusDeficit
     *
     * @return MeteorologicalForecast
     */
    public function setRainSurplusDeficit($rainSurplusDeficit = null)
    {
        $this->rainSurplusDeficit = $rainSurplusDeficit;

        return $this;
    }

    /**
     * Get rainSurplusDeficit.
     *
     * @return float|null
     */
    public function getRainSurplusDeficit()
    {
        return $this->rainSurplusDeficit;
    }

    /**
     * Set snowLast24hours.
     *
     * @param float|null $snowLast24hours
     *
     * @return MeteorologicalForecast
     */
    public function setSnowLast24hours($snowLast24hours = null)
    {
        $this->snowLast24hours = $snowLast24hours;

        return $this;
    }

    /**
     * Get snowLast24hours.
     *
     * @return float|null
     */
    public function getSnowLast24hours()
    {
        return $this->snowLast24hours;
    }

    /**
     * Set snowAccumulated.
     *
     * @param float|null $snowAccumulated
     *
     * @return MeteorologicalForecast
     */
    public function setSnowAccumulated($snowAccumulated = null)
    {
        $this->snowAccumulated = $snowAccumulated;

        return $this;
    }

    /**
     * Get snowAccumulated.
     *
     * @return float|null
     */
    public function getSnowAccumulated()
    {
        return $this->snowAccumulated;
    }

    /**
     * Set snowNormal.
     *
     * @param float|null $snowNormal
     *
     * @return MeteorologicalForecast
     */
    public function setSnowNormal($snowNormal = null)
    {
        $this->snowNormal = $snowNormal;

        return $this;
    }

    /**
     * Get snowNormal.
     *
     * @return float|null
     */
    public function getSnowNormal()
    {
        return $this->snowNormal;
    }

    /**
     * Set snowSurplusDeficit.
     *
     * @param float|null $snowSurplusDeficit
     *
     * @return MeteorologicalForecast
     */
    public function setSnowSurplusDeficit($snowSurplusDeficit = null)
    {
        $this->snowSurplusDeficit = $snowSurplusDeficit;

        return $this;
    }

    /**
     * Get snowSurplusDeficit.
     *
     * @return float|null
     */
    public function getSnowSurplusDeficit()
    {
        return $this->snowSurplusDeficit;
    }

    /**
     * Set satelitalImageUrl.
     *
     * @param string|null $satelitalImageUrl
     *
     * @return MeteorologicalForecast
     */
    public function setSatelitalImageUrl($satelitalImageUrl = null)
    {
        $this->satelitalImageUrl = $satelitalImageUrl;

        return $this;
    }

    /**
     * Get satelitalImageUrl.
     *
     * @return string|null
     */
    public function getSatelitalImageUrl()
    {
        return $this->satelitalImageUrl;
    }

    /**
     * Set seaConditionsAM.
     *
     * @param float|null $seaConditionsAM
     *
     * @return MeteorologicalForecast
     */
    public function setSeaConditionsAM($seaConditionsAM = null)
    {
        $this->seaConditionsAM = $seaConditionsAM;

        return $this;
    }

    /**
     * Get seaConditionsAM.
     *
     * @return float|null
     */
    public function getSeaConditionsAM()
    {
        return $this->seaConditionsAM;
    }

    /**
     * Set seaConditionsPM.
     *
     * @param float|null $seaConditionsPM
     *
     * @return MeteorologicalForecast
     */
    public function setSeaConditionsPM($seaConditionsPM = null)
    {
        $this->seaConditionsPM = $seaConditionsPM;

        return $this;
    }

    /**
     * Get seaConditionsPM.
     *
     * @return float|null
     */
    public function getSeaConditionsPM()
    {
        return $this->seaConditionsPM;
    }

    /**
     * Set seaConditions.
     *
     * @param string|null $seaConditions
     *
     * @return MeteorologicalForecast
     */
    public function setSeaConditions($seaConditions = null)
    {
        $this->seaConditions = $seaConditions;

        return $this;
    }

    /**
     * Get seaConditions.
     *
     * @return string|null
     */
    public function getSeaConditions()
    {
        return $this->seaConditions;
    }

    public static function getChoicesWindUnid(): array
    {
        return [
            self::WIND_UNIT_METERS_BY_SECOND => 'm/s',
            self::WIND_UNIT_KNOTS => 'nudos',
            self::WIND_UNIT_KILOMETERS_BY_HOUR => 'km/h',
        ];
    }

    public function getWindUnitName()
    {
        $namesArray = self::getChoicesWindUnid();

        return isset($namesArray[$this->getWindUnid()]) ? $namesArray[$this->getWindUnid()] : null;
    }

    public static function getChoicesPlace(): array
    {
        return [
            self::PLACE_CHACAY => 'Chacay',
            self::PLACE_MINA_LOS_PELAMBRES => 'Pelambres',
            self::PLACE_PUERTO_PUNTA_CHUNGO => 'Puerto',
            self::PLACE_VALLE_CHOAPA => 'Valle',
        ];
    }

    /**
     * Set dateObject.
     *
     * @param \DateTime $dateObject
     *
     * @return MeteorologicalForecast
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
     * getDictWeatherTypes function.
     *
     * @return array
     */
    public static function getWeatherTypesIconsNumber()
    {
        return [
            self::WEATHER_TYPE_CLEAR_SKY => '01',
            self::WEATHER_TYPE_FEW_CLOUDS => '02',
            self::WEATHER_TYPE_SCATTERED_CLOUDS => '03',
            self::WEATHER_TYPE_SHOWER_RAIN => '09',
            self::WEATHER_TYPE_RAIN => '10',
            self::WEATHER_TYPE_THUNDERSTORM => '11',
            self::WEATHER_TYPE_SNOW => '13',
            self::WEATHER_TYPE_MIST => '50',
        ];
    }

    /**
     * getWeatherTypeByIconNumber function.
     *
     * @param string $value
     *
     * @return string|null
     */
    public static function getWeatherTypeByIconNumber($value)
    {
        if ('04' === $value) { //No manejamos ícono para ese caso
            $value = '03';
        }
        $result = array_search($value, self::getWeatherTypesIconsNumber());

        return false === $result ? null : $result;
    }

    /**
     * Set generalWeatherIcon.
     *
     * @param string|null $generalWeatherIcon
     *
     * @return MeteorologicalForecast
     */
    public function setGeneralWeatherIcon($generalWeatherIcon = null)
    {
        $this->generalWeatherIcon = $generalWeatherIcon;

        return $this;
    }

    /**
     * Get generalWeatherIcon.
     *
     * @return string|null
     */
    public function getGeneralWeatherIcon()
    {
        return $this->generalWeatherIcon;
    }

    /**
     * Set weatherAMIcon.
     *
     * @param string|null $weatherAMIcon
     *
     * @return MeteorologicalForecast
     */
    public function setWeatherAMIcon($weatherAMIcon = null)
    {
        $this->weatherAMIcon = $weatherAMIcon;

        return $this;
    }

    /**
     * Get weatherAMIcon.
     *
     * @return string|null
     */
    public function getWeatherAMIcon()
    {
        return $this->weatherAMIcon;
    }

    /**
     * Set weatherPMIcon.
     *
     * @param string|null $weatherPMIcon
     *
     * @return MeteorologicalForecast
     */
    public function setWeatherPMIcon($weatherPMIcon = null)
    {
        $this->weatherPMIcon = $weatherPMIcon;

        return $this;
    }

    /**
     * Get weatherPMIcon.
     *
     * @return string|null
     */
    public function getWeatherPMIcon()
    {
        return $this->weatherPMIcon;
    }

    /**
     * Set visibility.
     *
     * @param string|null $visibility
     *
     * @return MeteorologicalForecast
     */
    public function setVisibility($visibility = null)
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Get visibility.
     *
     * @return string|null
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * Set windUnid.
     *
     * @param string $windUnid
     *
     * @return MeteorologicalForecast
     */
    public function setWindUnid($windUnid)
    {
        if (in_array($windUnid, array_values(self::getChoicesWindUnid()))) {
            $flip = array_flip(self::getChoicesWindUnid());
            $windUnid = $flip[$windUnid];
        }

        $this->windUnid = $windUnid;

        return $this;
    }

    /**
     * @JMS\VirtualProperty()
     * @JMS\SerializedName("wind_unit")
     * @JMS\Groups({"meteorological_forecast_detail"})
     */
    public function getWindUnidLabel()
    {
        $choices = self::getChoicesWindUnid();

        if (isset($choices[$this->getWindUnid()])) {
            return $choices[$this->getWindUnid()];
        }

        return null;
    }

    /**
     * Get windUnid.
     *
     * @return string
     */
    public function getWindUnid()
    {
        return $this->windUnid;
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
     * Get the value of humidity.
     *
     * @return float|null
     */
    public function getHumidity()
    {
        return $this->humidity;
    }

    /**
     * Set the value of humidity.
     *
     * @param float|null $humidity
     *
     * @return self
     */
    public function setHumidity($humidity = null)
    {
        $this->humidity = $humidity;

        return $this;
    }

    /**
     * Get the value of     .
     *
     * @return float|null
     */
    public function getMaximumHumidity()
    {
        return $this->maximumHumidity;
    }

    /**
     * Set the value of maximumHumidity.
     *
     * @param float|null $maximumHumidity
     *
     * @return self
     */
    public function setMaximumHumidity($maximumHumidity = null)
    {
        $this->maximumHumidity = $maximumHumidity;

        return $this;
    }

    /**
     * Get the value of electricActivity.
     *
     * @return float|null
     */
    public function getElectricActivity()
    {
        return $this->electricActivity;
    }

    /**
     * Set the value of electricActivity.
     *
     * @param float|null $electricActivity
     *
     * @return self
     */
    public function setElectricActivity($electricActivity = null)
    {
        $this->electricActivity = $electricActivity;

        return $this;
    }

    /**
     * Get the value of description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description.
     *
     * @return self
     */
    public function setDescription(string $description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of rainProbability.
     *
     * @return float|null
     */
    public function getRainProbability()
    {
        return $this->rainProbability;
    }

    /**
     * Set the value of rainProbability.
     *
     * @param float|null $rainProbability
     *
     * @return self
     */
    public function setRainProbability($rainProbability)
    {
        $this->rainProbability = $rainProbability;

        return $this;
    }

    /**
     * Get the value of snowProbability.
     *
     * @return float|null
     */
    public function getSnowProbability()
    {
        return $this->snowProbability;
    }

    /**
     * Set the value of snowProbability.
     *
     * @param float|null $snowProbability
     *
     * @return self
     */
    public function setSnowProbability($snowProbability)
    {
        $this->snowProbability = $snowProbability;

        return $this;
    }

    /**
     * Get the value of soilFreezing.
     *
     * @return bool
     */
    public function getSoilFreezing()
    {
        return $this->soilFreezing;
    }

    /**
     * Set the value of soilFreezing.
     *
     * @return self
     */
    public function setSoilFreezing(bool $soilFreezing)
    {
        $this->soilFreezing = $soilFreezing;

        return $this;
    }
}
