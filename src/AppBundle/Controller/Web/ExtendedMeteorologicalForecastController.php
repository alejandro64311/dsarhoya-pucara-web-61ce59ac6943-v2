<?php

namespace AppBundle\Controller\Web;

use AppBundle\Controller\BaseController;
use AppBundle\Model\Helper\ConfigHelper;
use AppBundle\Services\MineService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * API ExtendedMeteorologicalForecastController Controller.
 */
class ExtendedMeteorologicalForecastController extends BaseController
{
    /**
     * @Route("/extended-meteorological-forecast/{slug}", name="web_extended_meteorological_forecast_place")
     */
    public function getExtendedMeteorologicalforecastsAction(Request $request, $slug = null, MineService $mineService)
    {
        $mine = $mineService->getMine($request);
        $places = ConfigHelper::getMineDataBySlug($mine->getSlug())['places'];
        $slugs = array_keys($places);

        $slug = $slug ?: $slugs[0];

        $extendedForecasts = $this->getRepoMeteorologicalForecast()->meteorologicalForecasts([
            'date' => new \DateTime('now'),
            'limit' => 10,
            'mine' => $mine,
            'place' => $slug,
        ]);

        $extendedForecasts = array_slice($extendedForecasts, 3, 15);

        return $this->render('web/extended_meteorological_forecast/index.html.twig', [
            'mine' => $mine,
            'places' => $places,
            'slugs' => $slugs,
            'slug' => $slug,
            'extendedForecasts' => $extendedForecasts,
        ]);
    }
}
