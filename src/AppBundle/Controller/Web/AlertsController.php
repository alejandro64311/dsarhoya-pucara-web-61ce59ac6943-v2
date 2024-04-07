<?php

namespace AppBundle\Controller\Web;

use AppBundle\Controller\BaseController;
use AppBundle\Services\MineService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * AlertsController Controller.
 */
class AlertsController extends BaseController
{
    /**
     * @Route("/alerts", name="web_alerts")
     */
    public function alerts(Request $request, MineService $mineService)
    {
        $mine = $mineService->getMine($request);
        $alerts = $this->getRepoAlert()->findBy(['mine' => $mine, 'published' => true]);

        return $this->render('web/alerts/index.html.twig', [
            'alerts' => $alerts,
        ]);
    }
}
