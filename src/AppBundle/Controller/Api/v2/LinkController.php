<?php

namespace AppBundle\Controller\Api\v2;

use AppBundle\Controller\Api\ApiBaseController;
use AppBundle\Entity\Mine;
use AppBundle\Entity\WeatherTrend;
use FOS\RestBundle\Controller\Annotations\Get;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * API Link Controller.
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class LinkController extends ApiBaseController
{
    /**
     * Get Link List.
     *
     * @ParamConverter("mine", options={"mapping": {"mine": "slug"}})
     *
     * @return Response
     */
    public function getLinksAction(Request $request, Mine $mine)
    {
        $type = WeatherTrend::TYPE_WEATHER;
        //TODO si la app pide otro tipo, darlo.

        // return $this->serializedResponse($this->getRepoLink()->findBy(['mine' => $mine, 'type' => $type]), ['link_detail']);
        return $this->serializedResponse($this->getRepoLink()->findBy(['mine' => $mine]), ['link_detail']);
    }
}
