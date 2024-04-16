<?php

namespace AppBundle\Controller\Web;

use AppBundle\Controller\BaseController;
use AppBundle\Services\MineService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * WeatherTrendController Controller.
 */
class WeatherTrendController extends BaseController
{
    /**
     * @Route("/weather-trend/{type}", name="web_weather_trend")
     */
    public function getWheatherTrend(Request $request, $type, MineService $mineService)
    {
        $mine = $mineService->getMine($request);
        $trend = $this->getRepoWeatherTrend()->findOneBy(['mine' => $mine, 'type' => $type], ['id' => 'DESC']);

        return $this->render('web/weather_trend/index.html.twig', [
            'trend' => $trend,
            'type' => $type,
        ]);
    }
}
