<?php

namespace AppBundle\Controller\Api\v2;

use AppBundle\Services\WeatherService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use AppBundle\Controller\Api\ApiBaseController;
use AppBundle\Entity\Mine;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class WeatherController extends ApiBaseController
{
    /**
     * @ParamConverter("mine", options={"mapping": {"mine": "slug"}})
     * @Get("/mines/{mine}/weather/{location}")
     */
    public function getWeatherAction(Mine $mine, $location, WeatherService $weatherService)
    {
        $data = $weatherService->getWeatherInfo($mine, $location);

        try {
            return $this->serializedResponse([
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return $this->serializedResponse([
                'errors' => [
                    $e->getMessage(),
                ],
            ], [], 404);
        }
    }
}
