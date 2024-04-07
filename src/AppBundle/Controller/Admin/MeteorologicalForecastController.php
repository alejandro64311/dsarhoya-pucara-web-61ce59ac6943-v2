<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Exception\ImportException;
use AppBundle\Form\ImportType;
use AppBundle\Model\Helper\ConfigHelper;
use AppBundle\Services\ImportMeteorologicalForecastService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * MeteorologicalForecast Controller.
 *
 * @Route("/metereologial-forecats")
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class MeteorologicalForecastController extends BaseEAdminController
{
    /**
     * Import metereological forecast.
     *
     * @Route("/import", name="admin_meteorological_forecast_import")
     * @Method({"GET","POST"})
     * @Template()
     *
     * @param Company $company
     *
     * @return Response
     */
    public function importAction(Request $request, ImportMeteorologicalForecastService $importSrv)
    {
        $request->query->set('menuIndex', 1);
        $request->query->set('submenuIndex', 0);
        $form = $this->createForm(ImportType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $importSrv->import($form->get('file')->getData(), $this->mineService->getMine($request));
                $this->flashSuccess('Pronósticos cargados con éxito');
            } catch (ImportException $e) {
                $this->flashError($e->getMessage());
            }

            return $this->redirectToRoute('admin_meteorological_forecast_import');
        }
        $form = $form->createView();

        return compact('form');
    }

    /**
     * template import users.
     *
     * @Route("/import-template", name="admin_meteorological_forecast_import_template")
     *
     * @return Response
     */
    public function importTemplateAction(Request $request)
    {
        $choices = ConfigHelper::getPlaceChoicesBySlug($this->mineService->getMine($request)->getSlug());
        $choices = strtoupper(implode(', ', $choices));

        $headers = [
            '*Lugar ('.$choices.')',
            '*Fecha (dd/mm/yyyy)',
            'Fecha Emisión (dd/mm/yyyy 24:mm)',
            'Fecha de validez (dd/mm/yyyy 24:mm)',
            'Situación Sinóptica',
            'Visibilidad',
            'Tiempo general',
            'Tiempo general icono',
            'Tiempo AM',
            'Tiempo AM icono',
            'Tiempo PM',
            'Tiempo PM icono',
            'Temperatura mínima ºC',
            'Temperatura máxima ºC',
            'Isoterma',
            'Dirección AM (Viento)',
            'Dirección PM (Viento)',
            'Racha máxima (Viento)',
            'Unidad de medida viento (m/s, nudos, km/h)',
            'Radiación UV',
            'URL de mapa de radiación UV',
            'Últimas 24 horas (Lluvia)',
            'Acumulada (Lluvia)',
            'Normal (Lluvia)',
            'Superávit/Déficit (Lluvia)',
            'Probabilidad de lluvia (%)',
            'Actividad Eléctrica (%)',
            'Últimas 24 horas (Nieve)',
            'Acumulada (Nieve)',
            'Normal (Nieve)',
            'Superávit/Déficit (Nieve)',
            'Probabilidad de nieve (%)',
            'URL imagen de satelite',
            'Condición del mar (altura AM/PM mts.)',
            'Humedad mínima (%)',
            'Humedad máxima (%)',
            'Suelos Congelados (SI/NO)',
            'Situación sinop. Ext.',
        ];

        return $this->getTemplateImport($headers, 'plantilla_importacion_pronostico_metereologico');
    }
}
