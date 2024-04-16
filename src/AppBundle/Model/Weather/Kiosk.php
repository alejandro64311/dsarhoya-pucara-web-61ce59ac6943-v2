<?php

namespace AppBundle\Model\Weather;

use AppBundle\Model\Helper\ConfigHelper;
use Doctrine\ORM\EntityManagerInterface;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class Kiosk implements CurrentWeatherInterface
{
    public const KIOSK_BASE_URL = 'https://app.konectgds.com';
    public const MINUTES_CACHE = 1;

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getCurrentWeather($mine, $location, $useCache = true)
    {
        $mineData = ConfigHelper::getMineDataBySlug($mine->getSlug());

        if (!isset($mineData['places'][$location]['kiosk']) || empty($mineData['places'][$location]['kiosk'])) {
            return null;
        }

        $token = $mineData['places'][$location]['kiosk'];

        return $this->scrape($token);
    }

    private function scrape($kioskToken)
    {
        $client = new Client();
        $client->setHeader('user-agent', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36');

        $crawler = $client->request(
            'GET',
            self::KIOSK_BASE_URL."/Kiosk/{$kioskToken}"
        );

        $data = [
            'wind' => [],
        ];

        $crawler->filter('.widget-box')->each(function (Crawler $node, $i) use ($client, &$data) {
            if (false === $widgetData = json_decode($node->attr('data-widget-properties'), true)) {
                return;
            }

            if (in_array($widgetData['label'], ['TEMPERATURA DEL AIRE ACTUAL', 'TEMPERATURA DEL AIRE ACTUAL (°C)', 'Temperatura'])) {
                if (isset($widgetData['table'])) {
                    $t = $this->fetchData($client, $widgetData['table'], '{"select":["AirTC"],"top":1}');

                    if (null === $t) {
                        $t = $this->fetchData($client, $widgetData['table'], '{"select":["AirTC_Avg"],"top":1}');
                    }
                    if (null === $t) {
                        $t = $this->fetchData($client, $widgetData['table'], '{"select":["Temperatura_Avg"],"top":1}');
                    }

                    $data['temperature'] = $t;

                    return;
                }
            }
            if (in_array($widgetData['label'], ['HUMEDAD RELATIVA INSTANTANEA (%)', 'HUMEDAD RELATIVA', 'Humedad relativa (%)'])) {
                $h = $this->fetchData($client, $widgetData['table'], '{"select":["RH"],"top":1}');

                if (null === $h) {
                    $h = $this->fetchData($client, $widgetData['table'], '{"select":["Humedad"],"top":1}');
                }

                $data['humidity'] = $h;

                return;
            }

            if (in_array($widgetData['label'], ['RACHAS DE VIENTO ACTUAL', 'Rachas de viento'])) {
                $s = $this->fetchData($client, $widgetData['table'], '{"select":["WS_ms_Max"],"top":1}');

                if (null === $s) {
                    $s = $this->fetchData($client, $widgetData['table'], '{"select":["WS_Kmh_Max"],"top":1}');
                }
                if (null === $s) {
                    $s = $this->fetchData($client, $widgetData['table'], '{"select":["Velocidad_Max"],"top":1}');
                }

                $data['wind']['speed'] = $s;

                return;
            }
            if (in_array($widgetData['label'], ['DIRECCION DEL VIENTO', 'DIRECCIÓN DE VIENTO ACTUAL', 'DIRECCION DEL VIENTO (°)'])) {
                $data['wind']['deg'] = $this->fetchData($client, $widgetData['table'], '{"select":["WindDir_DU_WVT"],"top":1}');

                return;
            }
        });

        return $data;
    }

    private function fetchData(Client $client, $table, $body)
    {
        $client->request(
            'POST',
            self::KIOSK_BASE_URL."/api/GaugeData/{$table}",
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $body
        );
        $tempArray = json_decode($client->getResponse()->getContent(), true);

        if (isset($tempArray['Message'])) {
            return null;
        }

        return array_shift($tempArray);
    }
}
