<?php

namespace AppBundle\Controller\Api\v1;

use AppBundle\Controller\Api\ApiBaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\NamePrefix;

/**
 * API MaritimeForecast Controller.
 *
 * @NamePrefix("v1_")
 * 
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class MaritimeForecastController extends ApiBaseController
{
    /**
     * Get MaritimeForecast List.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function getMaritimeforecastsAction(Request $request)
    {
        $mine = $this->getRepoMine()->findOneBy(['slug' => 'pelambres']);

        return $this->forward('AppBundle\Controller\Api\v2\MaritimeForecastController::getMaritimeforecastsAction', [
            'mine' => $mine->getSlug(),
        ]);
    }
}
