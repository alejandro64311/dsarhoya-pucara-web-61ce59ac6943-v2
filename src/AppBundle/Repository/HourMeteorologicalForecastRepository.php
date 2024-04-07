<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Mine;
use AppBundle\Repository\Options\MeteorologicalForecastOption;
use Doctrine\ORM\QueryBuilder;

class HourMeteorologicalForecastRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return array|null
     */
    public function meteorologicalForecasts(array $optionsArray)
    {
        return $this->meteorologicalForecastsQueryBulder($optionsArray)->getQuery()->getResult();
    }

    public function meteorologicalForecastsQueryBulder(array $optionsArray): QueryBuilder
    {
        $options = new MeteorologicalForecastOption($optionsArray);
        $qb = $this->createQueryBuilder('mf');

        $qb->andWhere($qb->expr()->eq('mf.mine', ':mine'))->setParameter('mine', $options->getMine());

        /** @var \DateTime $begin */
        $begin = clone $options->getDate();
        $begin->setTime(0, 0, 0);

        $qb->andWhere($qb->expr()->gte('mf.date', ':date'))->setParameter('date', $begin);

        if (null !== $options->getPlace()) {
            $qb->andWhere($qb->expr()->eq('mf.place', ':place'))->setParameter('place', $options->getPlace());
        }

        if (is_array($options->getOrderBy())) {
            foreach ($options->getOrderBy() as $field => $direction) {
                $qb->addOrderBy('mf.'.$field, $direction);
            }
        } else {
            $qb
                ->orderBy('mf.place', 'asc')
                ->addOrderBy('mf.date', 'asc');
        }

        if (null !== $options->getLimit()) {
            $qb->getMaxResults($options->getLimit());
        }

        return $qb;
    }

    public function deleteAll(Mine $mine)
    {
        $qb = $this->createQueryBuilder('h');

        $qb->delete();
        $qb->andWhere('h.mine = :mine')->setParameter('mine', $mine);

        return $qb->getQuery()->execute();
    }
}
