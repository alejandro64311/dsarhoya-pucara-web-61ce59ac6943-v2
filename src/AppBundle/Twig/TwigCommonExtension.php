<?php

namespace AppBundle\Twig;

use AppBundle\Model\Helper\ConfigHelper;
use AppBundle\Model\Helper\SynopticSituationHelper;
use AppBundle\Services\WeatherService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\TwigTest;

// use dsarhoya\DSYFilesBundle\Services\DSYFilesService;

class TwigCommonExtension extends AbstractExtension
{
    private $synopticSituationHelper;
    private $weatherService;

    /**
     * Constructor.
     *
     * @param DSYFilesService $fileSrv
     */
    public function __construct(SynopticSituationHelper $synopticSituationHelper, WeatherService $weatherService)
    {
        $this->synopticSituationHelper = $synopticSituationHelper;
        $this->weatherService = $weatherService;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('showInfo', [$this, 'showInfo']),
            new TwigFunction('callUserFunc', [$this, 'callUserFunc']),
            new TwigFunction('filename', [$this, 'getFilename']),
            new TwigFunction('filename', [$this, 'getFilename']),
            new TwigFunction('placeWeatherInfo', [$this->weatherService, 'getWeatherInfo']),
            new TwigFunction('windUnit', [ConfigHelper::class, 'getWindUnit']),
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('icon_url', [$this, 'iconUrl']),
            new TwigFilter('uv_icon', [$this, 'uvIcon']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getTests()
    {
        return [
            new TwigTest('instanceof', [$this, 'instanceOf']),
        ];
    }

    /**
     * instanceOf Object.
     *
     * @param string $method
     * @param mixed  $object
     *
     * @return mixed
     */
    public function instanceof($value, $instance)
    {
        return $value instanceof $instance;
    }

    /**
     * Get value method of Object.
     *
     * @param string $method
     * @param mixed  $object
     *
     * @return mixed
     */
    public function callUserFunc($method, $object)
    {
        return call_user_func([$object, $method]);
    }

    /**
     * Get filemane.
     *
     * @param string $method
     * @param mixed  $object
     *
     * @return mixed
     */
    public function getFilename(string $fullPathAndKey = null)
    {
        if (null === $fullPathAndKey) {
            return null;
        }
        if (false !== strpos($fullPathAndKey, '/')) {
            $arr = explode('/', $fullPathAndKey);

            return array_pop($arr);
        } else {
            return $fullPathAndKey;
        }
    }

    /**
     * Get Value o return 'Sin Información'.
     *
     * @param string|null $value
     * @param string|null $code
     *
     * @return string
     */
    public function showInfo($value = '', $code = null)
    {
        $text = $value.(!empty($code) ? ' ('.$code.')' : '');

        return !empty($text) ? $text : 'Sin Información';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pcr.common.twig_extension';
    }

    public function iconUrl($iconName)
    {
        return $this->synopticSituationHelper->urlForIconNamed($iconName);
    }

    public function uvIcon($uv)
    {
        if (!is_numeric($uv)) {
            return null;
        }

        $uv = (int) $uv;

        if ($uv < 1) {
            return null;
        }

        if ($uv > 10) {
            return 'UV11.jpg';
        }

        return "UV$uv.jpg";
    }
}
