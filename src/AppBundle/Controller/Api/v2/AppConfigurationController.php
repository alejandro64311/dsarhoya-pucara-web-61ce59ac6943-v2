<?php

namespace AppBundle\Controller\Api\v2;

use AppBundle\Controller\Api\ApiBaseController;
use AppBundle\Entity\AppConfiguration;
use AppBundle\Entity\Mine;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Request;

class AppConfigurationController extends ApiBaseController
{
    /**
     * get risks controls.
     *
     * @Get("/mines/{slug}/configuration")
     */
    public function getconfigurationAction(Request $request, Mine $mine)
    {
        $options = [
            'mine' => $mine,
        ];
        if ($request->query->has('specific')) {
            $options['specific'] = $request->query->getBoolean('specific');
        }
        $risksControlsArray = $this->getRepoRisksControls()->findBy($options);
        $appConfig = $this->getRepoAppConfiguration()->findOneBy([
            'mine' => $mine,
        ]);

        if (null === $appConfig) {
            $appConfig = new AppConfiguration($mine);
            $this->getDoctrine()->getManager()->persist($appConfig);
            $this->getDoctrine()->getManager()->flush();
        }

        $config = [
            'config' => $appConfig,
            'risks_controls' => $risksControlsArray,
        ];

        return $this->serializedResponse($config, ['risks_controls_detail', 'app_configuration_detail']);
    }
}
