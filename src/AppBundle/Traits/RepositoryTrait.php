<?php

namespace AppBundle\Traits;

use AppBundle\Repository\AeronauticalForecastRepository;
use AppBundle\Repository\AlertRepository;
use AppBundle\Repository\AppConfigurationRepository;
use AppBundle\Repository\HourMeteorologicalForecastRepository;
use AppBundle\Repository\LinkRepository;
use AppBundle\Repository\MaritimeForecastRepository;
use AppBundle\Repository\MeteorologicalForecastRepository;
use AppBundle\Repository\MineRepository;
use AppBundle\Repository\RisksControlsRepository;
use AppBundle\Repository\RoadRepository;
use AppBundle\Repository\WeatherTrendRepository;

/**
 * Description of RepositoryTrait.
 *
 * @author snake77se
 */
trait RepositoryTrait
{
    protected $class = null;
    protected $bundle = 'AppBundle';

    /**
     * @param string $class
     * @param string $bundle
     *
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function repo($class = null, $bundle = null)
    {
        if (!is_string($class)) {
            $class = $this->class;
        }
        if (!is_string($bundle)) {
            $bundle = $this->bundle;
        }

        return $this->getDoctrine()->getRepository("$bundle:$class");
    }

    /**
     * @return \AppBundle\Repository\CompanyRepository
     */
    protected function getRepoCompany()
    {
        return $this->repo('Company');
    }

    /**
     * @return \AppBundle\Repository\ProfileRepository
     */
    protected function getRepoProfile()
    {
        return $this->repo('Profile');
    }

    /**
     * @return \AppBundle\Repository\ActionRepository
     */
    protected function getRepoAction()
    {
        return $this->repo('Action');
    }

    /**
     * @return \AppBundle\Repository\UserRepository
     */
    protected function getRepoUser()
    {
        return $this->repo('User');
    }

    /**
     * @return \dsarhoya\BaseBundle\Entity\UserKeyRepository
     */
    protected function getRepoUserKey()
    {
        return $this->repo('UserKey', 'dsarhoyaBaseBundle');
    }

    protected function getRepoMeteorologicalForecast(): MeteorologicalForecastRepository
    {
        return $this->repo('MeteorologicalForecast');
    }

    protected function getRepoHourMeteorologicalForecast(): HourMeteorologicalForecastRepository
    {
        return $this->repo('HourMeteorologicalForecast');
    }

    protected function getRepoAeronauticalForecast(): AeronauticalForecastRepository
    {
        return $this->repo('AeronauticalForecast');
    }

    protected function getRepoMaritimeForecast(): MaritimeForecastRepository
    {
        return $this->repo('MaritimeForecast');
    }

    protected function getRepoLink(): LinkRepository
    {
        return $this->repo('Link');
    }

    protected function getRepoAlert(): AlertRepository
    {
        return $this->repo('Alert');
    }

    /**
     * @return LinkRepository
     */
    protected function getRepoRoad(): RoadRepository
    {
        return $this->repo('Road');
    }

    protected function getRepoWeatherTrend(): WeatherTrendRepository
    {
        return $this->repo('WeatherTrend');
    }

    /**
     * @return MineRepository
     */
    protected function getRepoMine()
    {
        return $this->repo('Mine');
    }

    /**
     * @return RisksControlsRepository
     */
    protected function getRepoRisksControls()
    {
        return $this->repo('RisksControls');
    }

    /**
     * @return AppConfigurationRepository
     */
    protected function getRepoAppConfiguration()
    {
        return $this->repo('AppConfiguration');
    }
}
