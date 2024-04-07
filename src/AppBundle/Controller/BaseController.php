<?php

namespace AppBundle\Controller;

use dsarhoya\BaseBundle\Controller\BaseController as DSYBaseController;
use AppBundle\Entity\Company;

/**
 * PUCARA Base Controller
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class BaseController extends DSYBaseController
{
    const API_VERSION = 1;
    const API_PATH_INFO = 'api';

    use \AppBundle\Traits\BaseTrait;
    use \AppBundle\Traits\RepositoryTrait;
    use \AppBundle\Traits\ServiceTrait;
    use \AppBundle\Traits\FlashMessageTrait;
    use \AppBundle\Traits\UtilityTrait;
}
