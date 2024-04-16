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
 * ImportMaritimeForecast Service
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class ImportMaritimeForecastService extends AbstractImportForecastService
{
    /**
     * Contructor
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
        $this->className = 'MaritimeForecast';
        $this->columns = [
            ['name' => 'dateObject', 'trim' => true, 'format' => 'dd/mm/yyyy', 'constraints' => [new NotBlank(), $dateConstraint]],
            ['name' => 'code'],
            ['name' => 'emissionDate', 'trim' => true, 'format' => 'dd/mm/yyyy HH:mm', 'constraints' => [$dateTimeConstraint]],
            ['name' => 'validityDate', 'trim' => true, 'format' => 'dd/mm/yyyy HH:mm', 'constraints' => [$dateTimeConstraint]],
            ['name' => 'synopticSituation'],
            ['name' => 'minimumTemperature', 'constraints' => [$typeNumber]],
            ['name' => 'maximumTemperature', 'constraints' => [$typeNumber]],
            ['name' => 'forecast'],
            ['name' => 'seaState'],
            ['name' => 'windIntensity'],
            ['name' => 'windDirectionAM'],
            ['name' => 'windDirectionPM'],
            ['name' => 'windDirectionObservation'],
            ['name' => 'heightWavesGeneral'],
            ['name' => 'heightWavesAM'],
            ['name' => 'heightWavesPM'],
            ['name' => 'speedWavesAM'],
            ['name' => 'speedWavesPM'],
        ];
    }
}
