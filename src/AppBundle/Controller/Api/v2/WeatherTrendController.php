<?php

namespace AppBundle\Controller\Api\v2;

use AppBundle\Controller\Api\ApiBaseController;
use AppBundle\Entity\Mine;
use AppBundle\Error\Error400;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

/**
 * API WeatherTrend Controller.
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class WeatherTrendController extends ApiBaseController
{
    /**
     * @ParamConverter("mine", options={"mapping": {"mine": "slug"}})
     */
    public function getWeathertrendsAction(Request $request, Mine $mine)
    {
        $trend = $this->getRepoWeatherTrend()->findBy(['mine' => $mine], ['id' => 'DESC'], 1);

        if (empty($trend)) {
            throw new Error400('Trends not found.');
        }

        return $this->serializedResponse($trend[0], ['weather_trend_detail']);
    }
}
