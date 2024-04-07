<?php

namespace AppBundle\Controller\Api\v2;

use AppBundle\Controller\Api\ApiBaseController;
use AppBundle\Entity\Mine;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Get;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * API MaritimeForecast Controller.
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class MaritimeForecastController extends ApiBaseController
{
    /**
     * @param Request $request
     * @ParamConverter("mine", options={"mapping": {"mine": "slug"}})
     *
     * @return Response
     */
    public function getMaritimeforecastsAction(Request $request, Mine $mine)
    {
        $forecats = [];
        //get the last uploaded one
        $lastForecast = $this->getRepoMaritimeForecast()->findBy(['mine' => $mine], ['id' => 'desc']);
        if (0 < count($lastForecast)) {
            $forecats = $this->getRepoMaritimeForecast()->maritimeForecasts([
                'createdAt' => $lastForecast[0]->getCreatedAt(),
                'mine' => $mine,
            ]);
        }

        return $this->serializedResponse($forecats, ['maritime_forecast_detail']);
    }
}
