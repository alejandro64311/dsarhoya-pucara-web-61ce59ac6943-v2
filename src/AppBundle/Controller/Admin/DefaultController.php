<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\WeatherTrend;
use AppBundle\Model\Helper\SynopticSituationHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of BaseEAdminController.
 *
 * @Route("/")
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class DefaultController extends BaseEAdminController
{
    /**
     * homepage easyadmin.
     *
     * @Route("/homepage", name="easyHome")
     * @Method({"GET"})
     * @Template()
     *
     * @return Response
     */
    public function homeAction(Request $request)
    {
        return ['mine' => $this->mineService->getMine($request)];
    }

    /**
     * homepage easyadmin.
     *
     * @Route("/icons-reference", name="admin_icons_reference")
     * @Method({"GET"})
     * @Template()
     *
     * @return Response
     */
    public function iconsReferenceAction(Request $request)
    {
        $iconNames = SynopticSituationHelper::iconNames();

        return ['iconNames' => $iconNames];
    }

    /**
     * UploadCredentials action.
     *
     * @Route("/upload-credencials", name="upload_credencials")
     * @Method({"POST"})
     *
     * @return Response
     */
    public function uploadCredentailsActions(Request $request)
    {
        $destination_folder = WeatherTrend::PATH_FILE.'/';
        $signature = $this->getSignature($destination_folder, $request->request->get('filetype', ''));

        return $this->returnJson([
            'inputs' => $signature->getFormInputs(true),
            'url' => $signature->getFormUrl(),
            'approved_destination' => $destination_folder,
        ]);
    }
}
