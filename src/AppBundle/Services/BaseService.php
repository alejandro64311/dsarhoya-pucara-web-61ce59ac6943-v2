<?php
namespace AppBundle\Services;

use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Traits\UtilityTrait;

abstract class BaseService
{
    use UtilityTrait;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * Constructor
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
}
