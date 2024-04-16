<?php

namespace AppBundle\Controller\Api\v1;

use AppBundle\Controller\Api\ApiBaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\NamePrefix;

/**
 * API AeronauticalForecast Controller.
 * 
 * @NamePrefix("v1_")
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class AeronauticalForecastController extends ApiBaseController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getAeronauticalforecastsAction(Request $request)
    {
        $mine = $this->getRepoMine()->findOneBy(['slug' => 'pelambres']);

        return $this->forward('AppBundle\Controller\Api\v2\AeronauticalForecastController::getAeronauticalforecastsAction', [
            'mine' => $mine->getSlug(),
        ]);
    }
}
