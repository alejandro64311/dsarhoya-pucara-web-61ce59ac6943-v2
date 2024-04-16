<?php

namespace AppBundle\Controller\Api\v2;

use AppBundle\Controller\Api\ApiBaseController;
use AppBundle\Entity\Mine;
use AppBundle\Services\AeronauticalForecastService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * API AeronauticalForecast Controller.
 */
class AeronauticalForecastController extends ApiBaseController
{
    private $aeronauticalForecastService;

    public function __construct(AeronauticalForecastService $aeronauticalForecastService)
    {
        $this->aeronauticalForecastService = $aeronauticalForecastService;
    }

    /**
     * @ParamConverter("mine", options={"mapping": {"mine": "slug"}})
     *
     * @return Response
     */
    public function getAeronauticalforecastsAction(Request $request, Mine $mine)
    {
        $forecasts = $this->aeronauticalForecastService->getForecasts($mine);

        return $this->serializedResponse($forecasts, ['aeronautical_forecast_detail']);
    }
}
