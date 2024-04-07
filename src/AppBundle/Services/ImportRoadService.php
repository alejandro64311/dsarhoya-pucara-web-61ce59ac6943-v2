<?php

namespace AppBundle\Services;

use AppBundle\Entity\Mine;
use Doctrine\ORM\EntityManagerInterface;
use dsarhoya\DSYXLSBundle\Services\ExcelService;
use Symfony\Component\Form\FormFactoryInterface;
use AppBundle\Exception\ImportException;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Type;

/**
 * ImportRoad Service.
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class ImportRoadService extends AbstractImportForecastService
{
    /**
     * Contructor.
     *
     * @param EntityManagerInterface $em
     * @param ExcelService           $excelSrv
     * @param FormFactoryInterface   $formFactory
     */
    public function __construct(EntityManagerInterface $em, ExcelService $excelSrv, FormFactoryInterface $formFactory)
    {
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
        parent::__construct($em, $excelSrv, $formFactory);
        $this->className = 'Road';
        $this->columns = [
            ['name' => 'dateObject', 'trim' => true, 'format' => 'dd/mm/yyyy', 'constraints' => [new NotBlank(), $dateConstraint]],
            ['name' => 'name', 'trim' => true],
            ['name' => 'emissionDate', 'trim' => true, 'format' => 'dd/mm/yyyy HH:mm', 'constraints' => [$dateTimeConstraint]],
            ['name' => 'validityDate', 'trim' => true, 'format' => 'dd/mm/yyyy HH:mm', 'constraints' => [$dateTimeConstraint]],
            ['name' => 'transit'],
            ['name' => 'index'],
            ['name' => 'risk'],
            ['name' => 'condition'],
            ['name' => 'alert'],
            ['name' => 'observations'],
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
                if (null === ($road = $repo->findOneBy([
                    'dateObject' => $date,
                    'name' => $row['name'],
                    'mine' => $mine,
                ]))) {
                    $road = new $entityClassName($row['name'], $date);
                }

                $form = $this->formFactory->create($typeClass, $road, [
                    'csrf_protection' => false,
                    'allow_extra_fields' => true,
                    'slug_mine' => $mine->getSlug(),
                ]);
                if (!$form->submit($row, true)->isValid()) {
                    $dateFormat = null !== $row['dateObject'];
                    throw ImportException::createFromForm($form, "Nombre: {$row['name']}, Date: {$row['dateObject']}");
                }

                $road->setMine($mine);

                if (null === $road->getId()) {
                    $this->em->persist($road);
                }
                $this->em->flush($road);
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
            $row['name'] = strtoupper($row['name']);

            return $row;
        }, $rows);
    }
}
