<?php

namespace AppBundle\Repository;

use AppBundle\Repository\Options\SearchOption;
use Doctrine\ORM\QueryBuilder;

/**
 * AeronauticalForecastRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AeronauticalForecastRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param array $optionsArray
     * @return array|null
     */
    public function aeronauticalForecasts(array $optionsArray)
    {
        return $this->aeronauticalForecastsQueryBulder($optionsArray)->getQuery()->getResult();
    }

    /**
     * @param array $optionsArray
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function aeronauticalForecastsQueryBulder(array $optionsArray) : QueryBuilder
    {
        $options = new SearchOption($optionsArray);
        $qb = $this->createQueryBuilder('af');

        if (!is_null($options->getCreatedAt())){
            $qb->andWhere($qb->expr()->gte('af.createdAt', ':createdAt'))->setParameter('createdAt', $options->getCreatedAt());
        } else {
            /** @var \DateTime $begin */
            $begin = clone $options->getDate();
            $begin->setTime(0, 0, 0);
    
            // /** @var \DateTime $end */
            // $end = clone $options->getDate();
            // $end = null !== $options->getInterval() ? $end->add($options->getInterval()) : $end->add(new \DateInterval('P10D'));
            // $end->setTime(23, 59, 59);
            // $qb->andWhere($qb->expr()->between('af.emissionDate', ':begin', ':end'))
            //     ->setParameter('begin', $begin)
            //     ->setParameter('end', $end);
    
            $qb->andWhere($qb->expr()->gte('af.dateObject', ':date'))->setParameter('date', $begin);
        }

        if (is_array($options->getOrderBy())) {
            foreach ($options->getOrderBy() as $field => $direction) {
                $qb->addOrderBy($field, $direction);
            }
        } else {
            $qb->addOrderBy('af.dateObject', 'asc');
        }

        if (null !== $options->getLimit()) {
            $qb->getMaxResults($options->getLimit());
        }

        $qb->andWhere($qb->expr()->eq('af.mine', ':mine'))->setParameter('mine', $options->getMine());

        return $qb;
    }
}