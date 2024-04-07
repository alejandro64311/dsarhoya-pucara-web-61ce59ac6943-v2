<?php
namespace AppBundle\Services;

use AppBundle\Services\AbstractImportForecastService;
use Doctrine\ORM\EntityManagerInterface;
use dsarhoya\DSYXLSBundle\Services\ExcelService;
use Symfony\Component\Form\FormFactoryInterface;
use AppBundle\Exception\ImportException;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Type;

/**
 * ImportAeronauticalForecast Service
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class ImportAeronauticalForecastService extends AbstractImportForecastService
{
    /**
     * Constructor
     *
     * @param EntityManagerInterface $em
     * @param ExcelService $excelSrv
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(EntityManagerInterface $em, ExcelService $excelSrv, FormFactoryInterface $formFactory)
    {
        parent::__construct($em, $excelSrv, $formFactory);
        $dateConstraint = new DateTime([
            'format' => 'd/m/Y',
            'message' => 'Este valor {{ value }} no es una fecha valida, formato correcto es  "DD/MM/YYYY".',
        ]);
        $dateTimeConstraint = new DateTime([
            'format' => 'd/m/Y H:i',
            'message' => 'Este valor {{ value }} no es una fecha-hora valida, formato correcto es "DD/MM/YYYY HH:MM" (24H).',
        ]);
        $typeNumber = new Type([
            'type' => 'float',
            'message' => 'Este valor {{ value }} no es de tipo numérico.',
        ]);
        $this->className = 'AeronauticalForecast';
        $this->columns = [
            ['name' => 'dateObject', 'trim' => true, 'format' => 'dd/mm/yyyy', 'constraints' => [new NotBlank(), $dateConstraint]],
            ['name' => 'code'],
            ['name' => 'emissionDate', 'trim' => true, 'format' => 'dd/mm/yyyy HH:mm', 'constraints' => [$dateTimeConstraint]],
            ['name' => 'validityDate', 'trim' => true, 'format' => 'dd/mm/yyyy HH:mm', 'constraints' => [$dateTimeConstraint]],
            ['name' => 'synopticSituation'],
            ['name' => 'maximumTemperature', 'constraints' => [$typeNumber]],
            ['name' => 'minimumTemperature', 'constraints' => [$typeNumber]],
            ['name' => 'windSummary'],
            ['name' => 'operatingEstimate'],
            ['name' => 'synopticSituationRoute'],
            ['name' => 'santiagoPelambresRoute'],
            ['name' => 'serenaPelambresRoute'],
            ['name' => 'observations'],
        ];
    }
}
