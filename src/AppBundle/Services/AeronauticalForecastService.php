<?php

namespace AppBundle\Services;

use AppBundle\Entity\AeronauticalForecast;
use AppBundle\Entity\Mine;
use AppBundle\Repository\AeronauticalForecastRepository;

class AeronauticalForecastService extends BaseService
{
    /**
     * No entiendo la lógica, pero así estaba.
     *
     * @return AeronauticalForecast[]
     */
    public function getForecasts(Mine $mine)
    {
        $forecasts = [];
        /** @var AeronauticalForecastRepository $repoForecasts */
        $repoForecasts = $this->em->getRepository(AeronauticalForecast::class);

        $latestForecasts = $repoForecasts->findBy(['mine' => $mine], ['id' => 'desc']);
        if (count($latestForecasts) > 0) {
            $forecasts = $repoForecasts->aeronauticalForecasts([
               'createdAt' => $latestForecasts[0]->getCreatedAt(),
               'mine' => $mine,
            ]);
        }

        return $forecasts;
    }
}
