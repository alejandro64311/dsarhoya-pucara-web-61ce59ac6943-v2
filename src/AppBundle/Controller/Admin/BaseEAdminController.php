<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\User;
use AppBundle\Services\MineService;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Query\Parameter;
use dsarhoya\DSYEasyAdminBundle\Controller\EAdminController as DSYEasyAdminController;
use EasyCorp\Bundle\EasyAdminBundle\Exception\UndefinedEntityException;
use EddTurtle\DirectUpload\Signature;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of BaseEAdminController.
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class BaseEAdminController extends DSYEasyAdminController
{
    /** @var array The full configuration of the current parentEntity */
    protected $parentEntity = [];

    protected $mineService;

    use \AppBundle\Traits\BaseTrait;
    use \AppBundle\Traits\RepositoryTrait;
    use \AppBundle\Traits\ServiceTrait;
    use \AppBundle\Traits\FlashMessageTrait;

    public function __construct(MineService $mineService)
    {
        $this->mineService = $mineService;
    }

    /**
     * {@inheritdoc}
     */
    protected function initialize(Request $request)
    {
        parent::initialize($request);
        $parentEntity = null;
        if ($request->query->has('parentEntityId') && $request->query->has('parentEntityName')) {
            $parentEntityName = $this->request->query->get('parentEntityName');
            $parentEntityId = $this->request->query->get('parentEntityId');

            if (!array_key_exists($parentEntityName, $this->config['entities'])) {
                throw new UndefinedEntityException(['entity_name' => $parentEntityName]);
            }

            if (null === ($parentEntity = $this->getParentEntity($parentEntityName, $parentEntityId))) {
                throw new EntityNotFoundException(['entity_name' => $parentEntityName, 'entity_id_name' => 'Id', 'entity_id_value' => $parentEntityId]);
            }

            $this->parentEntity = $this->get('easyadmin.config.manager')->getEntityConfiguration($parentEntityName);
            $easyadmin = $this->request->attributes->get('easyadmin');
            $easyadmin['parentEntityItem'] = $parentEntity;
            $easyadmin['parentEntity'] = $this->parentEntity;
            $this->request->attributes->set('easyadmin', $easyadmin);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function createNewEntity()
    {
        $easyadmin = $this->request->attributes->get('easyadmin');

        $entity = parent::createNewEntity();
        if (isset($easyadmin['parentEntityItem']) and null !== $parentEntity = $easyadmin['parentEntityItem']) {
            $setParentEntity = 'set'.$easyadmin['parentEntity']['name'];
            $entity->$setParentEntity($parentEntity);
        }

        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    protected function deleteAction()
    {
        try {
            return parent::deleteAction();
        } catch (\Exception $e) {
            $this->flashError($this->getServiceTranslator()->trans($e->getMessage()));

            return $this->redirectToReferrer();
        }
    }

    public function getTemplateImport(array $headers, string $name)
    {
        $xls = $this->getServiceExcel()->getExcelFileFromCollection(
            $headers,
            [['row_data' => []]]
        );
        $today = new \DateTime('now');

        return $this->getServiceExcel()->returnExcelFile($xls, $name.'_'.$today->format('d-m-Y'));
    }

    /**
     * @param array $array
     *
     * @return Response
     */
    protected function returnJson($array)
    {
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Undocumented function.
     *
     * @param [type] $content_type
     *
     * @return Signature
     */
    public function getSignature(string $destination_folder, $content_type)
    {
        $signatureOptions = [
            'content_type' => $content_type,
            'valid_prefix' => $destination_folder,
            // "acl" => $company->getS3Permissions(),
            'acl' => 'public-read',
        ];

        return new Signature(
            $this->getParameter('s3_key'),
            $this->getParameter('s3_secret'),
            $this->getParameter('s3_bucket'),
            $this->getParameter('s3_region'),
            $signatureOptions
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function createSearchQueryBuilder($entityClass, $searchQuery, array $searchableFields, $sortField = null, $sortDirection = null, $dqlFilter = null)
    {
        $queryBuilder = parent::createSearchQueryBuilder($entityClass, $searchQuery, $searchableFields, $sortField, $sortDirection, $dqlFilter);
        $queryParameters = $queryBuilder->getParameters();

        $entityName = 'entity';
        foreach ($searchableFields as $fieldName => $metadata) {
            $dateObject = \DateTime::createFromFormat($metadata['format'], $searchQuery);
            if (in_array($metadata['dataType'], ['date', 'datetime']) && (false !== $dateObject)) {
                $dateObject->setTime(0, 0, 0);
                $queryBuilder->orWhere(sprintf('%s.%s = :dateObject', $entityName, $fieldName));
                $parameter = new Parameter('dateObject', $dateObject);
                $queryParameters->add($parameter);
            }
        }
        if (User::class !== $entityClass) {
            $queryBuilder->andWhere(sprintf('%s.mine = :mine', $entityName));
            $parameter = new Parameter('mine', $this->mineService->getMine($this->request));
            $queryParameters->add($parameter);
        }

        $queryBuilder->setParameters($queryParameters);

        return $queryBuilder;
    }

    /**
     * {@inheritdoc}
     */
    protected function persistEntity($entity)
    {
        if (!$entity instanceof User) {
            $mine = $this->mineService->getMine($this->request);
            $entity->setMine($mine);
            parent::persistEntity($entity);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null)
    {
        $filter = [];
        if (User::class !== $entityClass) {
            $filter[] = 'entity.mine = '.$this->mineService->getMine($this->request)->getId();
        }

        if (null !== $dqlFilter) {
            $filter[] = $dqlFilter;
        }

        $dqlFilter = count($filter) ? implode(' AND ', $filter) : null;

        // $dqlFilter = null !== $dqlFilter ? $dqlFilter.' AND '.$addDqlFilter : $addDqlFilter;

        return parent::createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);
    }
}
