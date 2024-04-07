<?php
namespace AppBundle\Controller\Admin;

use AppBundle\Controller\Admin\BaseEAdminController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Form\ImportType;
use AppBundle\Exception\ImportException;
use AppBundle\Services\ImportMaritimeForecastService;

/**
 * MaritimeForecast Controller
 *
 * @Route("/maritime-forecasts")
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class MaritimeForecastController extends BaseEAdminController
{
    /**
     * Import maritime forecast
     *
     * @Route("/import", name="admin_maritime_forecast_import")
     * @Method({"GET","POST"})
     * @Template()
     * @param Request $request
     * @param ImportMaritimeForecastService $importSrv
     * @param Company $company
     * @return Response
     */
    public function importAction(Request $request, ImportMaritimeForecastService $importSrv)
    {
        $request->query->set('menuIndex', 1);
        $request->query->set('submenuIndex', 2);
        $form = $this->createForm(ImportType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $importSrv->import($form->get('file')->getData(), $this->mineService->getMine($request));
                $this->flashSuccess("Pronósticos cargados con éxito");
            } catch (ImportException $e) {
                $this->flashError($e->getMessage());
            }
            return $this->redirectToRoute('admin_maritime_forecast_import');
        }
        $form = $form->createView();
        return compact('form');
    }

    /**
     * template import users
     *
     * @Route("/import-template", name="admin_maritime_forecast_import_template")
     * @return Response
     */
    public function importTemplateAction()
    {
        $headers = [
            '*Fecha (dd/mm/yyyy)',
            'Código',
            'Fecha Emisión (dd/mm/yyyy 24:mm)',
            'Fecha de validez (dd/mm/yyyy 24:mm)',
            'Situación Sinóptica',
            'Temperatura mínima ºC',
            'Temperatura máxima ºC',
            'Pronóstico',
            'Estado del mar',
            'Viento Intensidad (nudos)',
            'Dirección del viento AM',
            'Dirección del viento PM',
            'Observaciones',
            'Altura general de las olas (mts)',
            'Altura de las olas AM (mts)',
            'Altura de las olas PM (mts)',
            'Velocidad de las olas AM (nudos)',
            'Velocidad de las olas PM (nudos)',

        ];
        return $this->getTemplateImport($headers, ' plantilla_importacion_pronostico_maritimo');
    }
}
