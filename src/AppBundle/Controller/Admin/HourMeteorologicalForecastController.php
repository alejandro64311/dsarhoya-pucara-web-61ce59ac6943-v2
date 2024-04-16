<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Exception\ImportException;
use AppBundle\Form\ImportType;
use AppBundle\Model\Helper\ConfigHelper;
use AppBundle\Services\ImportHourMeteorologicalForecastService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * MeteorologicalForecast Controller.
 *
 * @Route("/web-metereological-forecast")
 *
 * @author jcordova <jhonny.cordova@dsarhoya.cl>
 */
class HourMeteorologicalForecastController extends BaseEAdminController
{
    /**
     * Import metereological forecast.
     *
     * @Route("/import", name="admin_hour_meteorological_forecast_import")
     * @Method({"GET","POST"})
     * @Template()
     *
     * @param Company $company
     *
     * @return Response
     */
    public function importAction(Request $request, ImportHourMeteorologicalForecastService $importSrv)
    {
        $request->query->set('menuIndex', 1);
        $request->query->set('submenuIndex', 1);
        $form = $this->createForm(ImportType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $importSrv->import($form->get('file')->getData(), $this->mineService->getMine($request), true);
                $this->flashSuccess('Pronósticos cargados con éxito');
            } catch (ImportException $e) {
                $this->flashError($e->getMessage());
            }

            return $this->redirectToRoute('admin_hour_meteorological_forecast_import');
        }
        $form = $form->createView();

        return compact('form');
    }

    /**
     * @Route("/import-template", name="admin_hour_meteorological_forecast_import_template")
     *
     * @return Response
     */
    public function importTemplateAction(Request $request)
    {
        $choices = ConfigHelper::getPlaceChoicesBySlug($this->mineService->getMine($request)->getSlug());
        $choices = strtoupper(implode(', ', $choices));

        $headers = [
            '*Lugar ('.$choices.')',
            '*Fecha y hora (dd/mm/yyyy 24:mm)',
            'Cobertura Nubosa (soleado, parcialmente nublado, nublado, chubascos, lluvia, tormenta, nieve, niebla)',
            'Dirección del viento',
            'Intensidad del viento',
            'Rachas de viento',
            'Temperatura',
            'Sensación Térmica',
            'Humedad relativa',
            'Prob. de precipitación',
            'Acumulación estimada',
            'Prob. actividad eléctrica',
        ];

        return $this->getTemplateImport($headers, 'plantilla_importacion_pronostico_metereologico_por_hora');
    }
}
