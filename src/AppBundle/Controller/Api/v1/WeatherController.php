<?php

namespace AppBundle\Controller\Api\v1;

use AppBundle\Controller\Api\ApiBaseController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\NamePrefix;

/**
 * @NamePrefix("v1_")
 */
class WeatherController extends ApiBaseController
{
    /**
     * @Get("/weather/{location}")
     */
    public function getWeatherAction(Request $request, $location)
    {
        $mine = $this->getRepoMine()->findOneBy(['slug' => 'pelambres']);

        return $this->forward('AppBundle\Controller\Api\v2\WeatherController::getWeatherAction', [
            'mine' => $mine->getSlug(),
            'location' => $location,
        ]);
    }
}
