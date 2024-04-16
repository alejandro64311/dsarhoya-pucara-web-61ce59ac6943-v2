<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Form\ImportType;
use AppBundle\Exception\ImportException;
use AppBundle\Services\ImportRoadService;

/**
 * Road Controller.
 *
 * @Route("/roads")
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class RoadController extends BaseEAdminController
{
    /**
     * Import maritime forecast.
     *
     * @Route("/import", name="admin_road_import")
     * @Method({"GET","POST"})
     * @Template()
     *
     * @param Request           $request
     * @param ImportRoadService $importSrv
     * @param Company           $company
     *
     * @return Response
     */
    public function importAction(Request $request, ImportRoadService $importSrv)
    {
        $request->query->set('menuIndex', 2);
        $request->query->set('submenuIndex', -1);
        $form = $this->createForm(ImportType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $importSrv->import($form->get('file')->getData(), $this->mineService->getMine($request));
                $this->flashSuccess('Pronósticos cargados con éxito');
            } catch (ImportException $e) {
                $this->flashError($e->getMessage());
            }

            return $this->redirectToRoute('admin_road_import');
        }
        $form = $form->createView();

        return compact('form');
    }

    /**
     * template import users.
     *
     * @Route("/import-template", name="admin_road_import_template")
     *
     * @return Response
     */
    public function importTemplateAction()
    {
        $headers = [
            '*Fecha (dd/mm/yyyy)',
            '*Nombre',
            'Fecha Emisión (dd/mm/yyyy 24:mm)',
            'Fecha de validez (dd/mm/yyyy 24:mm)',
            'Tránsito',
            'Índice',
            'Riesgo',
            'Condición',
            'Alertas',
            'Observaciones',
        ];

        return $this->getTemplateImport($headers, ' plantilla_importacion_caminos');
    }
}
