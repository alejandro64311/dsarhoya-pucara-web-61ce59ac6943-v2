<?php

namespace AppBundle\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="web_place_home")
     */
    public function indexAction(Request $request)
    {
        return $this->redirectToRoute('web_meteorological_forecast_place');
    }
}
