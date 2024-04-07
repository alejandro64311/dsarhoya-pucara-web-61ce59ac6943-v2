<?php

namespace AppBundle\Controller\Web;

use AppBundle\Controller\BaseController;
use AppBundle\Model\Helper\ConfigHelper;
use AppBundle\Services\MineService;
use AppBundle\Services\WeatherService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * API MeteorologicalForecast Controller.
 */
class MeteorologicalForecastController extends BaseController
{
    /**
     * @Route("/meteorological-forecast/{slug}", name="web_meteorological_forecast_place")
     */
    public function getMeteorologicalforecastsAction(Request $request, $slug = null, MineService $mineService, WeatherService $weatherService)
    {
        $mine = $mineService->getMine($request);
        $places = ConfigHelper::getMineDataBySlug($mine->getSlug())['places'];
        $slugs = array_keys($places);

        $slug = $slug ?: $slugs[0];

        $forecasts = $this->getRepoMeteorologicalForecast()->meteorologicalForecasts([
            'date' => new \DateTime('now'),
            'limit' => 10,
            'mine' => $mine,
            'place' => $slug,
        ]);

        $hourForecasts = $this->getRepoHourMeteorologicalForecast()->meteorologicalForecasts([
            'date' => new \DateTime('now'),
            'mine' => $mine,
            'place' => $slug,
            'orderBy' => ['date' => 'ASC'],
        ]);

        $firstForecasts = array_slice($forecasts, 0, 1);
        $forecasts = array_slice($forecasts, 1, 2);

        $currentWeatherInfo = [];
        try {
            if (true === ConfigHelper::showCurrentWeather($mine->getSlug(), $slug)) {
                $currentWeatherInfo = $weatherService->getWeatherInfo($mine, $slug);
            }
        } catch (\Throwable $th) {
        }

        return $this->render('web/meteorological_forecast/index.html.twig', [
            'places' => $places,
            'slugs' => $slugs,
            'slug' => $slug,
            'firstForecasts' => $firstForecasts,
            'forecasts' => $forecasts,
            'currentWeatherInfo' => $currentWeatherInfo,
            'hourForecasts' => $hourForecasts,
            'mine' => $mine,
        ]);
    }
}
