<?php

namespace AppBundle\Repository\Options;

use dsarhoya\BaseBundle\Options\BaseOptions;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Company;
use AppBundle\Entity\User;

/**
 * UserOption class
 */
class UserOption extends BaseOptions
{
    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'exclude_ids' => null,
            'dateFrom' => null,
            'dateTo' => null,
            'limit' => null,
            'role' => null,
            'state' => null,
            'accountValidated' => null,
        ));

        $resolver
            ->setRequired('company')->setAllowedTypes('company', [Company::class])
            ->setAllowedTypes('exclude_ids', ['null', 'array'])
            ->setAllowedTypes('dateFrom', ['null', \DateTime::class])
            ->setAllowedTypes('dateTo', ['null', \DateTime::class])
            ->setAllowedTypes('limit', ['null', 'integer'])
            ->setAllowedTypes('state', ['null', 'integer'])
            ->setAllowedTypes('accountValidated', ['null', 'integer'])
            ->setAllowedTypes('role', ['null', 'string'])
            ->setAllowedValues('role', function ($value) {
                return in_array($value, array_merge(array_keys(User::getRoleTypes()), [null]));
            });
    }

    /**
     * @return Company
     */
    public function getCompany() : Company
    {
        return $this->company;
    }

    /**
     * @return array|null
     */
    public function getExcludeIds()
    {
        return $this->exclude_ids;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * @return integer|null
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return integer|null
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return integer|null
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
}
