<?php

namespace AppBundle\Controller\Api\v1;

use AppBundle\Controller\Api\ApiBaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\NamePrefix;

/**
 * API MeteorologicalForecast Controller.
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class MeteorologicalForecastController extends ApiBaseController
{
    /**
     * Get MeteorologicalForecast List.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function getMeteorologicalforecastsAction(Request $request)
    {
        $mine = $this->getRepoMine()->findOneBy(['slug' => 'pelambres']);

        return $this->forward('AppBundle\Controller\Api\v2\MeteorologicalForecastController::getMeteorologicalforecastsAction', [
            'mine' => $mine->getSlug(),
        ]);
    }
}
