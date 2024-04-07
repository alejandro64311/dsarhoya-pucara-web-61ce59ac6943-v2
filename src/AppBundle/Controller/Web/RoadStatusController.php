<?php

namespace AppBundle\Controller\Web;

use AppBundle\Controller\BaseController;
use AppBundle\Services\MineService;
use AppBundle\Services\RoadsService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * RoadStatusController Controller.
 */
class RoadStatusController extends BaseController
{
    /**
     * @Route("/road-status", name="web_road_status")
     */
    public function getStatus(Request $request, MineService $mineService, RoadsService $roadsService)
    {
        $mine = $mineService->getMine($request);
        $roads = $roadsService->getRoadsStatus($mine);

        return $this->render('web/road_status/index.html.twig', [
            'roads' => $roads,
        ]);
    }
}
