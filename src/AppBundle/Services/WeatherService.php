<?php

namespace AppBundle\Services;

use AppBundle\Model\Weather\CurrentWeatherInterface;
use AppBundle\Model\Weather\HOBOLink;
use AppBundle\Model\Weather\Kiosk;
use AppBundle\Model\Weather\OpenWeatherMap;
use Symfony\Component\Cache\Simple\FilesystemCache;

class WeatherService extends BaseService
{
    private $currentWeatherInterfaces;

    public function __construct(OpenWeatherMap $o, Kiosk $k, HOBOLink $h)
    {
        $this->currentWeatherInterfaces = [
            $h,
            $k,
            $o,
        ];
    }

    public function getWeatherInfo($mine, $location, $useCache = true)
    {
        $cache = new FilesystemCache();
        $key = $mine->getSlug().'.'.$location;

        if ($cache->hasItem($key) && $useCache) {
            return $cache->get($key);
        }

        /** @var CurrentWeatherInterface $weatherInterface */
        foreach ($this->currentWeatherInterfaces as $weatherInterface) {
            if (null !== $weather = $weatherInterface->getCurrentWeather($mine, $location)) {
                break;
            }
        }

        if (null === $weather) {
            throw new \Exception('Current weather not found');
        }

        $cache->set($key, $weather, 300);

        return $weather;
    }
}
