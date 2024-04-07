<?php

namespace AppBundle\EventSubscriber;

use AppBundle\Entity\MeteorologicalForecast;
use AppBundle\Entity\RisksControls;
use AppBundle\Entity\WeatherTrend;
use dsarhoya\DSYFilesBundle\Services\DSYFilesService;
use JMS\Serializer\Context;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\JsonSerializationVisitor;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @author matias
 */
class SerializationSubscriber implements EventSubscriberInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $token;

    /**
     * @var DSYFilesService
     */
    private $fs;

    /**
     * @var Packages
     */
    private $assetsManager;

    private $request;

    /**
     * Constructor.
     */
    public function __construct(TokenStorageInterface $tokenStore, DSYFilesService $fs, Packages $assetsManager, RequestStack $requestStack)
    {
        $this->token = $tokenStore->getToken();
        $this->fs = $fs;
        $this->assetsManager = $assetsManager;
        $this->request = $requestStack->getMasterRequest();
    }

    public static function getSubscribedEvents()
    {
        return [
            ['event' => 'serializer.post_serialize', 'method' => 'onPostSerialize'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function onPostSerialize(ObjectEvent $event)
    {
        $entity = $event->getObject();

        /** @var Context $context */
        $context = $event->getContext();

        $visitor = $event->getVisitor();

        $groups = [];
        if ($context->hasAttribute('groups')) {
            $groups = $context->getAttribute('groups');
        }

        if ($visitor instanceof JsonSerializationVisitor) {
            if ($entity instanceof WeatherTrend) {
                $visitor->setData(
                    'file_key_url',
                    $entity->getFileKey() ? $this->fs->fileUrl($entity->getFileKey()) : null
                );
            }
            if ($entity instanceof MeteorologicalForecast) {
                $visitor->setData(
                    'general_weather_icon_url',
                    null !== $entity->getGeneralWeatherIcon() ? $this->request->getUriForPath("/assets/icons/{$entity->getGeneralWeatherIcon()}.png") : null
                );
                $visitor->setData(
                    'weather_am_icon_url',
                    null !== $entity->getWeatherAMIcon() ? $this->request->getUriForPath("/assets/icons/{$entity->getWeatherAMIcon()}.png") : null
                );
                $visitor->setData(
                    'weather_pm_icon_url',
                    null !== $entity->getWeatherPMIcon() ? $this->request->getUriForPath("/assets/icons/{$entity->getWeatherPMIcon()}.png") : null
                );

                if (null !== $entity->getSoilFreezing() && in_array('meteorological_forecast_detail', $groups)) {
                    $value = $entity->getSoilFreezing() ? RisksControls::SOIL_FREEZING_YES_LABEL : RisksControls::SOIL_FREEZING_NO_LABEL;
                    $visitor->setData('soil_freezing', $value);
                }
            }
        }
    }
}
