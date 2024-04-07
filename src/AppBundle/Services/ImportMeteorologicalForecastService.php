<?php

namespace AppBundle\Services;

use AppBundle\Entity\Mine;
use AppBundle\Entity\RisksControls;
use AppBundle\Exception\ImportException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use dsarhoya\DSYXLSBundle\Services\ExcelService;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

/**
 * ImportMeteorologicalForecast Service.
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class ImportMeteorologicalForecastService extends AbstractImportForecastService
{
    /**
     * Contructor.
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
        $yesNoConstraint = new Choice([
            'choices' => [RisksControls::SOIL_FREEZING_YES_LABEL, RisksControls::SOIL_FREEZING_NO_LABEL],
            'message' => 'Este valor {{ value }} no esta dentro de las opciones validas ("'.RisksControls::SOIL_FREEZING_YES_LABEL.'", "'.RisksControls::SOIL_FREEZING_NO_LABEL.'").',
        ]);

        $this->className = 'MeteorologicalForecast';
        $this->columns = [
            ['name' => 'place', 'trim' => true, 'constraints' => [new NotBlank()]],
            ['name' => 'dateObject', 'trim' => true, 'format' => 'dd/mm/yyyy', 'constraints' => [new NotBlank(), $dateConstraint]],
            ['name' => 'emissionDate', 'trim' => true, 'format' => 'dd/mm/yyyy HH:mm', 'constraints' => [$dateTimeConstraint]],
            ['name' => 'validityDate', 'trim' => true, 'format' => 'dd/mm/yyyy HH:mm', 'constraints' => [$dateTimeConstraint]],
            ['name' => 'synopticSituation'],
            ['name' => 'visibility'],
            ['name' => 'generalWeather'],
            ['name' => 'generalWeatherIcon', 'trim' => true],
            ['name' => 'weatherAM'],
            ['name' => 'weatherAMIcon', 'trim' => true],
            ['name' => 'weatherPM'],
            ['name' => 'weatherPMIcon', 'trim' => true],
            ['name' => 'minimumTemperature', 'constraints' => [$typeNumber]],
            ['name' => 'maximumTemperature', 'constraints' => [$typeNumber]],
            ['name' => 'isotherm'],
            ['name' => 'windDirectionAM'],
            ['name' => 'windDirectionPM'],
            ['name' => 'maximumGustWind'],
            ['name' => 'windUnid'],
            ['name' => 'uvRadiation'],
            ['name' => 'uvRadiationMapUrl'],
            ['name' => 'rainLast24hours', 'constraints' => [$typeNumber]],
            ['name' => 'rainAccumulated', 'constraints' => [$typeNumber]],
            ['name' => 'rainNormal', 'constraints' => [$typeNumber]],
            ['name' => 'rainSurplusDeficit', 'constraints' => [$typeNumber]],
            ['name' => 'rainProbability', 'constraints' => [$typeNumber]],
            ['name' => 'electricActivity', 'constraints' => [$typeNumber]],
            ['name' => 'snowLast24hours', 'constraints' => [$typeNumber]],
            ['name' => 'snowAccumulated', 'constraints' => [$typeNumber]],
            ['name' => 'snowNormal', 'constraints' => [$typeNumber]],
            ['name' => 'snowSurplusDeficit', 'constraints' => [$typeNumber]],
            ['name' => 'snowProbability', 'constraints' => [$typeNumber]],
            ['name' => 'satelitalImageUrl'],
            ['name' => 'seaConditions'],
            ['name' => 'humidity', 'constraints' => [$typeNumber]],
            ['name' => 'maximumHumidity', 'constraints' => [$typeNumber]],
            ['name' => 'soilFreezing', 'constraints' => [$yesNoConstraint]],
            ['name' => 'description'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function createFromRows(array $rows, string $className, Mine $mine)
    {
        $entityClassName = 'AppBundle\\Entity\\'.$className;
        $typeClass = 'AppBundle\\Form\\Import'.$className.'Type';

        $rows = $this->preProcessingRows($rows);

        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository($entityClassName);
        $this->em->getConnection()->beginTransaction();
        try {
            foreach ($rows as $row) {
                $date = \DateTime::createFromFormat('d/m/Y', $row['dateObject']);
                if (null === ($mForecast = $repo->findOneBy([
                    'dateObject' => $date,
                    'place' => $row['place'],
                    'mine' => $mine,
                ]))) {
                    $mForecast = new $entityClassName($row['place'], $date);
                }

                $form = $this->formFactory->create($typeClass, $mForecast, [
                    'csrf_protection' => false,
                    'allow_extra_fields' => true,
                    'slug_mine' => $mine->getSlug(),
                ]);
                if (!$form->submit($row, true)->isValid()) {
                    throw ImportException::createFromForm($form, "Place: {$row['place']}, Date: {$row['dateObject']}");
                }

                $mForecast->setMine($mine);

                if (null === $mForecast->getId()) {
                    $this->em->persist($mForecast);
                }
                $this->em->flush($mForecast);
            }
        } catch (\Exception $e) {
            $this->em->getConnection()->rollBack();
            throw $e;
        }
        $this->em->getConnection()->commit();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function preProcessingRows(array $rows): array
    {
        return array_map(function ($row) {
            $row['place'] = strtolower($row['place']);
            $row['generalWeatherIcon'] = strtoupper($row['generalWeatherIcon']);
            $row['weatherAMIcon'] = strtoupper($row['weatherAMIcon']);
            $row['weatherPMIcon'] = strtoupper($row['weatherPMIcon']);
            $row['soilFreezing'] = RisksControls::SOIL_FREEZING_YES_LABEL === strtoupper($row['soilFreezing']);

            return $row;
        }, $rows);
    }
}
