<?php
namespace AppBundle\Traits;

use AppBundle\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Utility Trait
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
trait UtilityTrait
{
    /**
     * Get Company
     *
     * @return Company
     * @throws \Exception EntityManager not found
     * @throws \Exception Company not found
     */
    public function getCompany() : Company
    {
        $em = null;

        if (property_exists($this, 'em') && $this->em instanceof EntityManagerInterface) {
            $em = $this->em;
        }
        
        if ($this instanceof Controller && is_callable([$this, 'getDoctrine'])) {
            $em = $this->getDoctrine()->getManager();
        }

        if (null === $em) {
            throw new \Exception("EntityManager not found.");
        }

        if (null === ($company = $em->getRepository(Company::class)->findOneBy([
            'deletedAt' => null,
            'state' => Company::ESTADO_ACTIVA
        ]))) {
            throw new \Exception("Company not found");
        }
        return $company;
    }

    /**
     * Transforms a camelCasedString to an under_scored_one
     *
     * @return string
     */
    public function underscore($cameled) : string
    {
        return implode(
            '_',
            array_map(
                'strtolower',
                preg_split('/([A-Z]{1}[^A-Z]*)/', $cameled, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY)
            )
        );
    }

    /**
     * Transforms an under_scored_string to a camelCasedOne
     *
     * @return string
     */
    public function camelize($scored) : string
    {
        return lcfirst(implode('', array_map('ucfirst', array_map('strtolower', explode('_', $scored)))));
    }

    /**
     * Transforms an under_scored_string to a camelCasedOne
     *
     * @return string
     */
    public function camelizeMinus($scored) : string
    {
        return lcfirst(implode('', array_map('ucfirst', array_map('strtolower', explode('-', $scored)))));
    }
}
