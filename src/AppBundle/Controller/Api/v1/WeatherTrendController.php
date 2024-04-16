<?php

namespace AppBundle\Controller\Api\v1;

use Symfony\Component\HttpFoundation\Response;
use AppBundle\Controller\Api\ApiBaseController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\NamePrefix;


/**
 * API WeatherTrend Controller.
 *
 * @NamePrefix("v1_")
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class WeatherTrendController extends ApiBaseController
{
    /**
     * Get WeatherTrend List.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function getWeathertrendsAction(Request $request)
    {
        $mine = $this->getRepoMine()->findOneBy(['slug' => 'pelambres']);

        return $this->forward('AppBundle\Controller\Api\v2\WeatherTrendController::getWeathertrendsAction', [
            'mine' => $mine->getSlug(),
        ]);
    }
}
