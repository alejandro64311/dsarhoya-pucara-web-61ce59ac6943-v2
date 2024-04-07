<?php

namespace AppBundle\Controller\Web;

use AppBundle\Controller\BaseController;
use AppBundle\Services\MineService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * OtherResourcesController Controller.
 */
class OtherResourcesController extends BaseController
{
    /**
     * @Route("/other-resources/{type}", name="web_other_resources")
     */
    public function getOtherResources(Request $request, $type, MineService $mineService)
    {
        $mine = $mineService->getMine($request);
        $links = $this->getRepoLink()->findBy(['mine' => $mine, 'type' => $type]);

        return $this->render('web/other_resources/index.html.twig', [
            'links' => $links,
            'type' => $type,
        ]);
    }
}
