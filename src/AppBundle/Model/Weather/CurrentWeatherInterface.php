<?php

namespace AppBundle\Model\Weather;

interface CurrentWeatherInterface
{
    public function getCurrentWeather($mine, $location);
}
