<?php
namespace AppBundle\Traits;

/**
 * FlashMessage Trait
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
trait FlashMessageTrait
{
    protected function flashInfo($message)
    {
        return $this->addFlash(self::FLASH_TYPE_INFO, $message);
    }
    
    protected function flashSuccess($message)
    {
        return $this->addFlash(self::FLASH_TYPE_SUCCESS, $message);
    }
    
    protected function flashError($message)
    {
        return $this->addFlash(self::FLASH_TYPE_ERROR, $message);
    }
    
    protected function flashWarning($message)
    {
        return $this->addFlash(self::FLASH_TYPE_WARNING, $message);
    }
}
