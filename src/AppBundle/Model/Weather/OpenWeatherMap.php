<?php

namespace AppBundle\Model\Weather;

use AppBundle\Entity\MeteorologicalForecast;
use AppBundle\Entity\Mine;
use AppBundle\Model\Helper\ConfigHelper;
use AppBundle\Services\ConfigService;
use Symfony\Component\HttpFoundation\RequestStack;

class OpenWeatherMap implements CurrentWeatherInterface
{
    const WEATHER_API_BASE_URL = 'https://api.openweathermap.org/data/2.5';

    private $weatherApiKey;
    private $request;

    public function __construct(ConfigService $configService, RequestStack $requestStack)
    {
        $this->weatherApiKey = $configService->getWeatherApiKey();
        $this->request = $requestStack->getMasterRequest();
    }

    public function getCurrentWeather($mine, $location)
    {
        $coords = $this->getCoords($mine, $location);
        $url = $this->createUrl($coords['lat'], $coords['lng']);
        $response = $this->fetchWeatherInfo($url);

        if (200 !== $response['cod']) {
            throw new \Exception($response['message']);
        }

        $icon = null;
        $iconUrl = null;
        if (isset($response['weather'][0]['icon'])) {
            $icon = $response['weather'][0]['icon'];
            $iconUrl = $this->getIconUrlFromIcon($response['weather'][0]['icon']);
        }

        return [
            'temperature' => $response['main']['temp'],
            'humidity' => $response['main']['humidity'],
            'wind' => $response['wind'],
            // 'icon' => $icon,
            // 'icon_url' => $iconUrl,
        ];
    }

    private function getIconUrlFromIcon($icon)
    {
        if (null === $this->request) {
            return null;
        }

        $imageName = MeteorologicalForecast::getWeatherTypeByIconNumber(substr($icon, 0, 2));

        if (null === $imageName) {
            return null;
        }

        return $this->request->getUriForPath("/assets/icons/$imageName.png");
    }

    private function getCoords(Mine $mine, $location)
    {
        try {
            $mineData = ConfigHelper::getMineDataBySlug($mine->getSlug());

            return $mineData['places'][$location]['coords'];
        } catch (\Throwable $th) {
            throw new \Exception('Place not implemented');
        }
    }

    private function createUrl($lat, $lng)
    {
        return self::WEATHER_API_BASE_URL.'/weather?lat='.$lat.'&lon='.$lng.'&units=metric&appid='.$this->weatherApiKey;
    }

    private function fetchWeatherInfo($url)
    {
        $cURL = curl_init();

        curl_setopt($cURL, CURLOPT_URL, $url);
        curl_setopt($cURL, CURLOPT_HTTPGET, true);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
        ]);
        $response = curl_exec($cURL);

        return json_decode($response, true);
    }
}
