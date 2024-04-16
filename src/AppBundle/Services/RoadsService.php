<?php

namespace AppBundle\Services;

use AppBundle\Entity\Mine;
use AppBundle\Entity\Road;
use AppBundle\Repository\RoadRepository;

class RoadsService extends BaseService
{
    /**
     * No entiendo la lógica, pero así estaba.
     *
     * @return Road[]
     */
    public function getRoadsStatus(Mine $mine)
    {
        /** @var RoadRepository $roadsRepo */
        $roadsRepo = $this->em->getRepository(Road::class);
        $roads = [];
        $latestRoads = $roadsRepo->findBy(['mine' => $mine], ['id' => 'desc']);
        if (count($latestRoads) > 0) {
            $roads = $roadsRepo->roads([
                'createdAt' => $latestRoads[0]->getCreatedAt(),
                'mine' => $mine,
            ]);
        }

        return $roads;
    }
}
