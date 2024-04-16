<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\AppConfiguration;
use AppBundle\Repository\AppConfigurationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AppConfigurationController extends BaseEAdminController
{
    /**
     * @Route("/show-app-config", name="admin_show_app_config", methods={"GET"})
     */
    public function showConfigAction(Request $request)
    {
        $mine = $this->mineService->getMine($request);
        $em = $this->getDoctrine()->getManager();
        /** @var AppConfigurationRepository $repo */
        $repo = $em->getRepository(AppConfiguration::class);

        /** @var AppConfiguration $appConfig */
        $appConfig = $repo->findOneBy([
            'mine' => $mine,
        ]);

        if (null === $appConfig) {
            $appConfig = new AppConfiguration($mine);
            $em->persist($appConfig);
            $em->flush();
        }

        return $this->redirectToRoute('easyadmin', [
            'entity' => 'AppConfiguration',
            'action' => 'show',
            'id' => $appConfig->getId(),
            'menuIndex' => 9,
            'submenuIndex' => 0,
        ]);
    }
}
