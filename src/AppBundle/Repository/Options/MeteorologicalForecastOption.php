<?php

namespace AppBundle\Repository\Options;

use AppBundle\Entity\MeteorologicalForecast;
use AppBundle\Entity\Mine;
use AppBundle\Model\Helper\ConfigHelper;
use dsarhoya\BaseBundle\Options\BaseOptions;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * MeteorologicalForecast Option.
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class MeteorologicalForecastOption extends BaseOptions
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'place' => null,
            'date' => null,
            'interval' => null,
            'orderBy' => null,
            'limit' => null,
            'mine' => null,
        ]);

        $resolver
            ->setRequired('date')
            ->setRequired('mine')
            ->setAllowedTypes('mine', [Mine::class])
            ->setAllowedTypes('place', ['null', 'string'])
            ->setAllowedTypes('date', [\DateTime::class])
            ->setAllowedTypes('interval', ['null', \DateInterval::class])
            ->setAllowedTypes('orderBy', ['null', 'array'])
            ->setAllowedTypes('limit', ['null', 'integer'])
            ->setAllowedValues('place', function ($value) {
                if (null === $value) {
                    return true;
                }

                return in_array($value, ConfigHelper::getAllPlacesSlugs());
                // return in_array($value, array_keys(MeteorologicalForecast::getChoicesPlace()));
            });
    }

    /**
     * @return string|null
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return \DateInterval|null
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * @return array|null
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @return int|null
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return Mine
     */
    public function getMine()
    {
        return $this->mine;
    }
}
