<?php
namespace AppBundle\Services;

use AppBundle\Entity\Mine;
use AppBundle\Services\BaseService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use dsarhoya\DSYXLSBundle\Services\ExcelService;
use dsarhoya\DSYXLSBundle\XLS\Loader\ColumnOptions;
use Symfony\Component\Form\FormFactoryInterface;
use AppBundle\Exception\ImportException;
use Doctrine\ORM\EntityRepository;
use dsarhoya\DSYXLSBundle\XLS\Loader\ExcelLoader;

/**
 * AbstractImportForecast Service
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
abstract class AbstractImportForecastService extends BaseService
{
    /**
     * @var ExcelService
     */
    protected $excelSrv;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var array
     */
    protected $columns;

    /**
     * @var string
     */
    protected $className;

    /**
     * Constructor
     *
     * @param EntityManagerInterface $em
     * @param ExcelService $excelSrv
     */
    public function __construct(EntityManagerInterface $em, ExcelService $excelSrv, FormFactoryInterface $formFactory)
    {
        parent::__construct($em);
        $this->excelSrv = $excelSrv;
        $this->formFactory = $formFactory;
    }

    /**
     * createLoader function
     *
     * @param array $columns
     * @return ExcelLoader
     */
    protected function createLoader(array $columns)
    {
        /** @var ExcelLoader $loader */
        $loader = $this->excelSrv->getExcelLoader();
        $loader->setLoaderIndex(0);
        foreach ($columns as $column) {
            $loader->addCell(new ColumnOptions($column));
        }

        return $loader;
    }

    /**
     * import file xls
     *
     * @param UploadedFile $file
     * @return boolean
     */
    public function import(UploadedFile $file, Mine $mine)
    {
        $loader = $this->createLoader($this->columns);

        $res = $loader->load($file);

        if (!$loader->isValid()) {
            throw ImportException::createfromArray($loader->getErrors());
            return false;
        }


        $this->createFromRows($res, $this->className, $mine);

        return true;
    }

    /**
     * import function
     *
     * @param array $data
     * @return boolean
     */
    protected function createFromRows(array $rows, string $className, Mine $mine)
    {
        $entityClassName = 'AppBundle\\Entity\\' . $className;
        $typeClass = 'AppBundle\\Form\\Import' . $className . 'Type';

        $rows = $this->preProcessingRows($rows);

        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository($entityClassName);
        $this->em->getConnection()->beginTransaction();
        try {
            foreach ($rows as $row) {
                $date = \DateTime::createFromFormat('d/m/Y', $row['dateObject']);
                if (null === ($forecast = $repo->findOneBy([
                    'dateObject' => $date,
                    'mine' => $mine
                ]))) {
                    $forecast = new $entityClassName($date);
                }

                $form = $this->formFactory->create($typeClass, $forecast, [
                    'csrf_protection' => false,
                    'allow_extra_fields' => true,
                    'slug_mine' => $mine->getSlug()
                ]);
                if (!$form->submit($row, true)->isValid()) {
                    throw ImportException::createFromForm($form, "Date: {$row['dateObject']}");
                }

                $forecast->setMine($mine);

                if (null === $forecast->getId()) {
                    $this->em->persist($forecast);
                }
                $this->em->flush($forecast);
            }
        } catch (\Exception $e) {
            $this->em->getConnection()->rollBack();
            throw $e;
        }
        $this->em->getConnection()->commit();
        return true;
    }

    /**
     * @param array $rows
     * @return array
     */
    protected function preProcessingRows(array $rows): array
    {
        return $rows;
    }
}
