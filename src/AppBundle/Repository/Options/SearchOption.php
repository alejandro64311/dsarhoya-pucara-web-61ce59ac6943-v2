<?php

namespace AppBundle\Repository\Options;

use dsarhoya\BaseBundle\Options\BaseOptions;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Search Option.
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class SearchOption extends BaseOptions
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'criteria' => null,
            'orderBy' => null,
            'date' => null,
            'approved' => null,
            'companyName' => null,
            'role' => null,
            'state' => null,
            'accountValidated' => null,
            'limit' => null,
            'createdAt' => null,
            'mine' => null
        ]);

        $resolver
            ->setAllowedTypes('criteria', ['null', 'string'])
            ->setAllowedTypes('state', ['null', 'string', 'integer'])
            ->setAllowedTypes('orderBy', ['null', 'array'])
            ->setAllowedTypes('date', ['null', \DateTime::class])
            ->setAllowedTypes('approved', ['null', 'boolean'])
            ->setAllowedTypes('companyName', ['null', 'string'])
            ->setAllowedTypes('accountValidated', ['null', 'integer'])
            ->setAllowedTypes('role', ['null', 'string'])
            ->setAllowedTypes('limit', ['null', 'integer'])
            ->setAllowedTypes('createdAt', ['null', \DateTime::class])
            ;
    }

    /**
     * @return string|null
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @return string|int|null
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return \DateTime|null
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return bool|null
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * @return string|null
     */
    public function getCompanyName()
    {
        return $this->companyName;
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
    public function getAccountValidated()
    {
        return $this->accountValidated;
    }

    /**
     * @return string|null
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return int|null
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getMine()
    {
        return $this->mine;
    }
}
