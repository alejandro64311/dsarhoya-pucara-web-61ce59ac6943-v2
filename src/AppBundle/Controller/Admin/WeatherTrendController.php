<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Controller\Admin\BaseEAdminController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilder;
use dsarhoya\FormTypesBundle\Form\Type\DropzoneType;
use AppBundle\Entity\WeatherTrend;
use EddTurtle\DirectUpload\Signature;
use dsarhoya\FormTypesBundle\Services\DropzoneService;

/**
 * WeatherTrend Controller
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class WeatherTrendController extends BaseEAdminController
{
    /**
     * {@inheritDoc}
     */
    protected function createWeatherTrendEntityFormBuilder($entity, $view)
    {
        // $formOptions = $this->executeDynamicMethod('get<EntityName>EntityFormOptions', array($entity, $view));

        /** @var FormBuilder $formBuilder */
        $formBuilder = parent::createEntityFormBuilder($entity, $view);
        $deleteFileKeyUrl = null !== $entity->getId() ? $this->generateUrl('admin_weather_trend_file_key', ['id' => $entity->getId()]) : null;

        $uploader = $this->getSignature(WeatherTrend::PATH_FILE, $this->request->request->get('filetype', ''));
        /** @var DropzoneService $dropzoneSrv */
        $dropzoneSrv = $this->container->get('dsy.formtypes.dropzone.service');
        // dump($deleteFileKeyUrl);
        // dump($dropzoneSrv->getDropzoneFileMock($entity, 'fileKey', 'pdf'));
        // die;

        $formBuilder->add('fileKey', DropzoneType::class, [
            'label' => 'Archivo (PDF)',
            'uploadUrl' => $uploader->getFormUrl(),
            'credentialsUrl' => $this->generateUrl('upload_credencials'),
            'acceptedFiles' => 'application/pdf',
            // 'successUrl' => $saveFileKeyUrl,
            'deletedUrl' => $deleteFileKeyUrl,
            'preloadImages' => $dropzoneSrv->getDropzoneFileMock($entity, 'fileKey', 'pdf'),
            // 'mapped' => false,
            'required' => true,
            'dictRemoveFile' => 'Borrar',
            'dictDefaultMessage' => 'Arrastre y suelte para cargar imagen segundaria (max. 2MB)',
            'dictCancelUpload' => 'Cancelar',
            'dictMaxFilesExceeded' => 'Cantidad maxima de archivos excedida',
            'dictFileTooBig' => 'Tamaño de archivo excedido',
        ]);

        return $formBuilder;
    }

    /**
     * Set File PDF
     *
     * @Route("/setfilekey/{id}", name="admin_weather_trend_file_key")
     * @Method({"POST"})
     * @param Request $request
     * @param WeatherTrend $weatherTrend
     * @return Response
     */
    public function setFileKeyAction(Request $request, WeatherTrend $weatherTrend)
    {
        $key = $request->request->get('key', null);
        $delete = (!is_string($key) || empty($key)) ? true : false;

        if (!$delete) {
            $weatherTrend->setFileKey($key);
        } else {
            $weatherTrend->setFileKey(null);
        }
        // $this->getDoctrine()->getManager()->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
