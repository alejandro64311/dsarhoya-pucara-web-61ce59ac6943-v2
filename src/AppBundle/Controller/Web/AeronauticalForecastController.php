<?php

namespace AppBundle\Controller\Web;

use AppBundle\Controller\BaseController;
use AppBundle\Services\AeronauticalForecastService;
use AppBundle\Services\MineService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * AeronauticalForecastController Controller.
 */
class AeronauticalForecastController extends BaseController
{
    /**
     * @Route("/secured/aeronautical-forecast", name="web_aeronautical_forecast")
     */
    public function getForecast(Request $request, MineService $mineService, AeronauticalForecastService $aeronauticalForecastService)
    {
        $mine = $mineService->getMine($request);
        $forecasts = $aeronauticalForecastService->getForecasts($mine);

        return $this->render('web/aeronautical_forecast/index.html.twig', [
            'forecast' => array_shift($forecasts), //el primero que encuentre.
        ]);
    }
}
