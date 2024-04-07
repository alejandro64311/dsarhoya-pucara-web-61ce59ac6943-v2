<?php

namespace AppBundle\Controller\Api\v1;

use AppBundle\Controller\Api\ApiBaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\NamePrefix;

use AppBundle\Controller\Api\v2\LinkController as V2LinkController;

/**
 * API Link Controller.
 *
 * @NamePrefix("v1_")
 * 
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class LinkController extends ApiBaseController
{
    /**
     * Get Link List.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function getLinksAction(Request $request)
    {
        $mine = $this->getRepoMine()->findOneBy(['slug' => 'pelambres']);

        return $this->forward('AppBundle\Controller\Api\v2\LinkController::getLinksAction', [
            'mine' => $mine->getSlug(),
        ]);
    }
}
