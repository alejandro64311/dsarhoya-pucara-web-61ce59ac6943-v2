<?php

namespace AppBundle\Controller\Api\v2;

use AppBundle\Controller\Api\ApiBaseController;
use AppBundle\Entity\Mine;
use AppBundle\Services\RoadsService;
use FOS\RestBundle\Controller\Annotations\Get;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * API Road Controller.
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class RoadController extends ApiBaseController
{
    private $roadsService;

    public function __construct(RoadsService $roadsService)
    {
        $this->roadsService = $roadsService;
    }

    /**
     * Get Road List.
     *
     * @ParamConverter("mine", options={"mapping": {"mine": "slug"}})
     *
     * @return Response
     */
    public function getRoadsAction(Request $request, Mine $mine)
    {
        $roads = $this->roadsService->getRoadsStatus($mine);

        return $this->serializedResponse($roads, ['road_detail']);
    }
}
