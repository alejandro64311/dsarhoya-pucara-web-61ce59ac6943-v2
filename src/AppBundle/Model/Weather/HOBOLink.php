<?php

namespace AppBundle\Model\Weather;

use AppBundle\Model\Helper\ConfigHelper;
use Doctrine\ORM\EntityManagerInterface;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class HOBOLink implements CurrentWeatherInterface
{
    public const BASE_URL = 'https://www.hobolink.com';
    public const MINUTES_CACHE = 1;

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getCurrentWeather($mine, $location, $useCache = true)
    {
        $mineData = ConfigHelper::getMineDataBySlug($mine->getSlug());

        if (!isset($mineData['places'][$location]['hobo_link']) || empty($mineData['places'][$location]['hobo_link'])) {
            return null;
        }

        $credentials = $mineData['places'][$location]['hobo_link'];

        $data = is_array($credentials) ? $this->scrapeWithLogin($credentials, $location) : $this->scrapeWithToken($credentials);

        return $data;
    }

    private function scrapeWithToken(string $token)
    {
        $client = new Client();
        $client->setHeader('user-agent', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36');

        $crawler = $client->request(
            'GET',
            self::BASE_URL."/p/{$token}"
        );

        $res = $this->scrape($crawler);

        return $res;
    }

    private function scrapeWithLogin(array $credentials, string $location)
    {
        $client = new Client();
        $client->setHeader('user-agent', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36');

        $crawler = $client->request(
            'GET',
            self::BASE_URL
        );

        $token = $crawler->filter('input[name="javax.faces.ViewState"]')->first()->attr('value');

        $crawler = $client->request(
            'POST',
            self::BASE_URL,
            [
                'login-form' => 'login-form',
                'login-form:j_idt34' => $credentials['username'],
                'login-form:j_idt36' => $credentials['password'],
                'login-form:j_idt38' => 'Log+in',
                'javax.faces.ViewState' => $token,
            ]
        );

        $linkLabel = strtoupper($location);

        if (isset($credentials['link_label'])) {
            $linkLabel = $credentials['link_label'];
        }

        try {
            $link = $crawler->selectLink($linkLabel);
            $link = $link->link();
            $crawler = $client->click($link);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $this->scrape($crawler);
    }

    private function scrape(Crawler $crawler)
    {
        $data = [
            'wind' => [],
        ];

        $crawler->filter('div.latest-conditions-info,div.latest-conditions-info-analog')->each(function (Crawler $node) use (&$data) {
            $spans = $node->filter('span');

            //para inglés y espakol
            if (false !== strpos($spans->first()->text(), 'Temperatur')) {
                $span = $spans->eq(1);
                $data['temperature'] = $span->text();

                return;
            }

            foreach (['RH', 'Humedad Relativa', 'Humedad relativa del Aire'] as $possibility) {
                if (false !== strpos($spans->first()->text(), $possibility)) {
                    $span = $spans->eq(1);
                    $data['humidity'] = $span->text();

                    return;
                }
            }

            foreach (['Wind Speed', 'Velocidad del Viento', 'Velocidad de Viento'] as $possibility) {
                if (false !== strpos($spans->first()->text(), $possibility)) {
                    $span = $spans->eq(1);
                    $data['wind']['speed'] = $span->text();

                    return;
                }
            }
        });

        return $data;
    }
}
