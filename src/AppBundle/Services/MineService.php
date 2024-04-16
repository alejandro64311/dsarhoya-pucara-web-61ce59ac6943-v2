<?php

namespace AppBundle\Services;

use AppBundle\Entity\Mine;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class MineService
{
    private $em;
    private $configService;

    public function __construct(EntityManagerInterface $em, ConfigService $configService)
    {
        $this->em = $em;
        $this->configService = $configService;
    }

    public function getMine(Request $request): Mine
    {
        $subdomain = explode('.', $request->getHost())[0];

        return $this->getMineBySubdomain($subdomain);
    }

    public function getMineBySubdomain($subdomain): ?Mine
    {
        $mine = $this->em->getRepository(Mine::class)->findOneBy([
            'subdomain' => $subdomain,
        ]);

        if (null === $mine) {
            if ('pucara_pelambres' === $subdomain) { //si es pelambres, ocupo el otro sub dominio.
                $mine = $this->em->getRepository(Mine::class)->findOneBy([
                    'subdomain' => 'pucaratest',
                ]);
                if (null !== $mine) {
                    return $mine;
                }
            }

            if ('dev' === $this->configService->env) {
                $mines = $this->em->getRepository(Mine::class)->findBy([
                    'slug' => 'collahuasi',
                ]);

                return array_shift($mines);
            }

            if ('stage' === $this->configService->env) {
                $mines = $this->em->getRepository(Mine::class)->findBy([
                    'slug' => $this->configService->stageMine,
                ]);

                if (!empty($mines)) {
                    return array_shift($mines);
                }
            }
            throw new \Exception('Esa Mina no existe');
        }

        return $mine;
    }
}
