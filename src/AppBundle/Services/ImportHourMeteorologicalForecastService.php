<?php

namespace AppBundle\Services;

use AppBundle\Entity\Mine;
use AppBundle\Exception\ImportException;
use AppBundle\Repository\HourMeteorologicalForecastRepository;
use Doctrine\ORM\EntityManagerInterface;
use dsarhoya\DSYXLSBundle\Services\ExcelService;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * ImportHourMeteorologicalForecast Service.
 *
 * @author jcordova <jhonny.cordova@dsarhoya.cl>
 */
class ImportHourMeteorologicalForecastService extends AbstractImportForecastService
{
    /**
     * Contructor.
     */
    public function __construct(EntityManagerInterface $em, ExcelService $excelSrv, FormFactoryInterface $formFactory)
    {
        parent::__construct($em, $excelSrv, $formFactory);

        $dateTimeConstraint = new DateTime([
            'format' => 'd/m/Y H:i',
            'message' => 'Este valor {{ value }} no es una fecha-hora valida, formato correcto es "DD/MM/YYYY HH:MM" (24H).',
        ]);

        $this->className = 'HourMeteorologicalForecast';
        $this->columns = [
            ['name' => 'place', 'trim' => true, 'constraints' => [new NotBlank()]],
            ['name' => 'date', 'trim' => true, 'format' => 'dd/mm/yyyy HH:mm', 'constraints' => [new NotBlank(), $dateTimeConstraint]],
            ['name' => 'cloudCoverIcon', 'trim' => true],
            ['name' => 'windDirection'],
            ['name' => 'windIntensity'],
            ['name' => 'windGusts'],
            ['name' => 'temperature'],
            ['name' => 'thermalSensation'],
            ['name' => 'relativeHumidity'],
            ['name' => 'precipitationProbability'],
            ['name' => 'estimatedAccumulation'],
            ['name' => 'electricalActivityProbability'],
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

        /** @var HourMeteorologicalForecastRepository $repo */
        $repo = $this->em->getRepository($entityClassName);
        $this->em->getConnection()->beginTransaction();

        $repo->deleteAll($mine);

        try {
            foreach ($rows as $row) {
                $date = \DateTime::createFromFormat('d/m/Y H:i', $row['date']);
                if (null === ($mForecast = $repo->findOneBy([
                    'date' => $date,
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
                    throw ImportException::createFromForm($form, "Place: {$row['place']}, Date: {$row['date']}");
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
            $row['cloudCoverIcon'] = strtoupper($row['cloudCoverIcon']);

            return $row;
        }, $rows);
    }
}
