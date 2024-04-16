<?php

namespace AppBundle\Controller\Api\v2;

use AppBundle\Controller\Api\ApiBaseController;
use AppBundle\Entity\Mine;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Error\InvalidDateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * API MeteorologicalForecast Controller.
 */
class MeteorologicalForecastController extends ApiBaseController
{
    /**
     * Get MeteorologicalForecast List.
     * @ParamConverter("mine", options={"mapping": {"mine": "slug"}})
     */
    public function getMeteorologicalforecastsAction(Request $request, Mine $mine)
    {
        if (!$request->query->has('date')) {
            $date = new \DateTime('now');
        } elseif (false === $date = \DateTime::createFromFormat('d/m/Y', $request->query->get('date'))) {
            throw new InvalidDateTime($request->query->get('date'), 'DD/MM/YYYY');
        }
        $forecats = $this->getRepoMeteorologicalForecast()->meteorologicalForecasts([
            'date' => $date,
            'limit' => 10,
            'mine' => $mine
        ]);

        return $this->serializedResponse($forecats, ['meteorological_forecast_detail']);
    }
}
