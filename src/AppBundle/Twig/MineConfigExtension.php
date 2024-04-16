<?php

namespace AppBundle\Twig;

use AppBundle\Model\Helper\ConfigHelper;
use AppBundle\Services\MineService;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class MineConfigExtension extends AbstractExtension
{
    private $mineService;
    private $requestStack;

    public function __construct(MineService $mineService, RequestStack $requestStack)
    {
        $this->mineService = $mineService;
        $this->requestStack = $requestStack;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('mine', [$this, 'mine']),
            new TwigFunction('mine_slug', [$this, 'mineSlug']),
            new TwigFunction('show_menu', [$this, 'showMenu']),
            new TwigFunction('show_current_weather', [$this, 'showCurrentWeather']),
            new TwigFunction('show_place_forecast_in_menu', [$this, 'showPlaceForecastInMenu']),
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('place_name', [$this, 'placeName']),
        ];
    }

    public function placeName($place)
    {
        $request = $this->requestStack->getMasterRequest();
        $mine = $this->mineService->getMine($request);

        return ConfigHelper::getPlaceName($mine->getSlug(), $place);
    }

    public function mine($request = null)
    {
        if (null === $request) {
            $request = $this->requestStack->getMasterRequest();
        }

        return $this->mineService->getMine($request);
    }

    public function mineSlug($request = null)
    {
        if (null === $request) {
            $request = $this->requestStack->getMasterRequest();
        }

        $mine = $this->mineService->getMine($request);

        return $mine->getSlug();
    }

    public function showCurrentWeather($place)
    {
        $request = $this->requestStack->getMasterRequest();
        $mine = $this->mineService->getMine($request);

        return ConfigHelper::showCurrentWeather($mine->getSlug(), $place);
    }

    public function showMenu($menu)
    {
        $request = $this->requestStack->getMasterRequest();
        $mine = $this->mineService->getMine($request);

        return ConfigHelper::showMenu($mine->getSlug(), $menu);
    }

    public function showPlaceForecastInMenu()
    {
        $request = $this->requestStack->getMasterRequest();
        $mine = $this->mineService->getMine($request);

        return ConfigHelper::showPlaceForecastInMenu($mine->getSlug());
    }
}
