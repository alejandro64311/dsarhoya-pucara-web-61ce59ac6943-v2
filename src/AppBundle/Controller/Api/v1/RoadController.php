<?php

namespace AppBundle\Controller\Api\v1;

use AppBundle\Controller\Api\ApiBaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\NamePrefix;

/**
 * API Road Controller.
 *
 * @NamePrefix("v1_")
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class RoadController extends ApiBaseController
{
    /**
     * Get Road List.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function getRoadsAction(Request $request)
    {
        $mine = $this->getRepoMine()->findOneBy(['slug' => 'pelambres']);

        return $this->forward('AppBundle\Controller\Api\v2\RoadController::getRoadsAction', [
            'mine' => $mine->getSlug(),
        ]);
    }
}
