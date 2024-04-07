<?php

namespace AppBundle\Traits;

/**
 * @author snake77se at dsarhoya.cl
 */
trait ServiceTrait
{
    /**
     * @return \JMS\Serializer\Serializer
     */
    protected function getServiceSerializer()
    {
        return $this->get('jms_serializer');
    }

    /**
     * @return \Monolog\Logger
     */
    protected function getServiceMonolog()
    {
        return $this->get('logger');
    }

    /**
     * @return \dsarhoya\DSYXLSBundle\Services\ExcelService
     */
    protected function getServiceExcel()
    {
        return $this->get('dsarhoya.xls');
    }

    /**
     * @return \Knp\Component\Pager\PaginatorInterface
     */
    protected function getServiceKNPPaginator() : \Knp\Component\Pager\PaginatorInterface
    {
        return $this->get('knp_paginator');
    }

    /**
     * @return \Symfony\Component\Validator\Validator\RecursiveValidator
     */
    protected function getServiceValidator()
    {
        return $this->get('validator');
    }

    /**
     * @return \Symfony\Bundle\FrameworkBundle\Translation\Translator
     */
    protected function getServiceTranslator()
    {
        return $this->get('translator');
    }

    /**
     * @return \dsarhoya\DSYFilesBundle\Services\DSYFilesService
     */
    public function getServiceFiles()
    {
        return $this->get('dsarhoya.files');
    }
}
