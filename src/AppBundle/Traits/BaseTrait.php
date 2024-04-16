<?php

namespace AppBundle\Traits;

/**
 * BaseTrait
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
trait BaseTrait
{
    /**
     *
     * @return string
     */
    public function getEnv()
    {
        return $this->container->getParameter('kernel.environment');
    }

    /**
     * @return \dsarhoya\BaseBundle\Services\EmailService
     */
    protected function getServiceEmails()
    {
        return $this->get('dsarhoya.base.email_service');
    }

    /**
     * @return \dsarhoya\BaseBundle\Services\UserManagementService
     */
    protected function getServiceUserManagementService()
    {
        return $this->get('dsarhoya.base.usermanagement');
    }

    /**
     * @return \dsarhoya\BaseBundle\Services\ProfileManagementService
     */
    protected function getServiceProfileManagementService()
    {
        return $this->get('dsarhoya.base.profilemanagement');
    }

    /**
     * @return \dsarhoya\BaseBundle\Services\CompanyManagementService
     */
    protected function getServiceCompanyManagementService()
    {
        return $this->get('dsarhoya.base.companymanagement');
    }

    /**
     * @return \dsarhoya\BaseBundle\Services\UserKeysService
     */
    protected function getServiceUserKeys()
    {
        return $this->get('dsarhoya.base.userkeysservice');
    }

    /**
     * @return \dsarhoya\BaseBundle\Services\BaseKeysService
     */
    protected function getServiceBaseKeys()
    {
        return $this->get('dsarhoya\BaseBundle\Services\BaseKeysService');
    }
}
