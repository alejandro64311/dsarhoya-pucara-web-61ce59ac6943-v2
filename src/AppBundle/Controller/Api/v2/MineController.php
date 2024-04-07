<?php

namespace AppBundle\Controller\Api\v2;

use AppBundle\Controller\Api\ApiBaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Mine;
use FOS\RestBundle\Controller\Annotations\Get;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * API AeronauticalForecast Controller.
 * 
 */
class MineController extends ApiBaseController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getMineAction(Request $request, Mine $mine)
    {
        throw new \Exception("Método no implementado", 400);
        
    }
}
