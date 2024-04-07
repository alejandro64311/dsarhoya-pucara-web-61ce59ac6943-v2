<?php

namespace AppBundle\Model\Helper;

class ConfigHelper
{
    public const MINES = [
        // PELAMBRES ----------------
        'pelambres' => [
            'places' => [
                'pelambres' => [
                    'kiosk' => '0563c60a-e66c-4578-a4ec-e72de8d847b5',
                    'coords' => ['lat' => -31.734, 'lng' => -70.492],
                ],
                'chacay' => [
                    'kiosk' => '0bdaee1b-05ec-47dc-9e4a-f81da2634d8f',
                    'coords' => ['lat' => -31.822, 'lng' => -70.581],
                ],
                'valle' => [
                    'kiosk' => '759464a0-a2a5-483e-9d91-a2c0e3736e45',
                    'coords' => ['lat' => -31.991, 'lng' => -71.007],
                    'name' => 'El Mauro-Valle',
                ],
                'puerto' => [
                    'kiosk' => '',
                    'coords' => ['lat' => -31.885, 'lng' => -71.498],
                ],
            ],
        ],

        // COLLAHUASI ----------------
        'collahuasi' => [
            'places' => [
                'rosario' => [
                    'kiosk' => 'b9eed6ad-0902-48dc-a2cd-00eabfac4d0d',
                    'coords' => ['lat' => '', 'lng' => ''],
                    'hobo_link' => [
                        'username' => 'sisdefchile',
                        'password' => 'Sisdefchile2023@',
                        'link_label' => 'Est. Meteorologica Rosario',
                    ],
                ],
                'coposa' => [
                    'kiosk' => 'fa35cc9f-37c0-4070-b99f-877e14b5dc24',
                    'coords' => ['lat' => '', 'lng' => ''],
                    'hobo_link' => [
                        'username' => 'sisdefchile',
                        'password' => 'Sisdefchile2023@',
                        'link_label' => 'Est. Meteorológica Coposa',
                    ],
                ],
                'ujina' => [
                    'kiosk' => 'e23c4ff6-fe14-4874-a06d-9de83c66969f',
                    'coords' => ['lat' => '', 'lng' => ''],
                    'hobo_link' => [
                        'username' => 'sisdefchile',
                        'password' => 'Sisdefchile2023@',
                        'link_label' => 'Est. Meteorológica Ujina',
                    ],
                ],
                'puerto' => [
                    'kiosk' => '',
                    'coords' => ['lat' => -31.885, 'lng' => -71.498],
                    'hobo_link' => [
                        'username' => 'sisdefchile',
                        'password' => 'Sisdefchile2023@',
                        'link_label' => 'Est. Meteorológica Patache',
                    ],
                ],
            ],
            'config' => [
                'hides_aeronautical_forecast' => true,
                'wind_unit' => 'Km/hr',
            ],
        ],

        // CASERONES ----------------
        'caserones' => [
            'places' => [
                'refugio_mina' => [
                    'kiosk' => 'cfc87f75-cce9-4797-9c95-b902d7bc56da',
                    'coords' => ['lat' => -31.885, 'lng' => -71.498],
                    'name' => 'Mina Planta',
                ],
                'carrizalillo' => [
                    'kiosk' => '986d19a1-02e4-4544-b4d7-8d17ac49f39d',
                    'coords' => ['lat' => -31.885, 'lng' => -71.498],
                    'name' => 'Carrizalillo-Valle',
                ],
                'planta_piloto' => [
                    'kiosk' => '67a5f217-6b60-464e-855b-0c0c96f085f7',
                    'coords' => ['lat' => -31.885, 'lng' => -71.498],
                    'name' => 'Planta Piloto-Muro',
                ],
            ],
            'config' => [
                'hides_aeronautical_forecast' => true,
            ],
        ],

        // TENIENTE ----------------
        'teniente' => [
            'places' => [
                'joachim' => [
                    'kiosk' => '',
                    'hobo_link' => '28ef34d0d0ab1bb49f7cfc000311b91a',
                    'coords' => ['lat' => -31.885, 'lng' => -71.498],
                    'show_current_weather' => false,
                ],
                'piques' => [
                    'kiosk' => '',
                    'hobo_link' => '28ef34d0d0ab1bb49f7cfc000311b91a',
                    'coords' => ['lat' => -31.885, 'lng' => -71.498],
                    'name' => 'Piques',
                    'show_current_weather' => false,
                ],
                'sewell' => [
                    'kiosk' => '',
                    'hobo_link' => '28ef34d0d0ab1bb49f7cfc000311b91a',
                    'coords' => ['lat' => -31.885, 'lng' => -71.498],
                    'show_current_weather' => false,
                ],
            ],
            'config' => [
                'hides_aeronautical_forecast' => true,
                'show_place_forecast_in_menu' => 'joachim',
            ],
        ],
    ];

    public static function getMineDataBySlug(string $slug)
    {
        return self::MINES[$slug];
    }

    public static function getAllMineData()
    {
        return self::MINES;
    }

    public static function getAllPlacesSlugs(): array
    {
        $choices = [];

        foreach (self::MINES as $mineData) {
            foreach ($mineData['places'] as $slug => $placeData) {
                $choices[] = $slug;
            }
        }

        return $choices;
    }

    public static function getPlaceChoicesBySlug(string $slug)
    {
        $mineData = self::MINES[$slug];

        $choices = [];
        foreach ($mineData['places'] as $place => $value) {
            $choices[$place] = ucfirst($place);
        }

        return $choices;
    }

    public static function getPlaceName($slug, $place)
    {
        $data = self::getMineDataBySlug($slug);

        return isset($data['places'][$place]['name']) ? $data['places'][$place]['name'] : ucfirst($place);
    }

    public static function showCurrentWeather($slug, $place)
    {
        $data = self::getMineDataBySlug($slug);
        $place = $data['places'][$place];

        return isset($place['show_current_weather']) ? $place['show_current_weather'] : true;
    }

    public static function showMenu($slug, $menu)
    {
        $data = self::getMineDataBySlug($slug);
        $config = isset($data['config']) ? $data['config'] : [];

        if (!isset($config["hides_$menu"])) {
            return true;
        }

        return true !== $config["hides_$menu"];
    }

    public static function showPlaceForecastInMenu($slug)
    {
        $data = self::getMineDataBySlug($slug);

        if (!isset($data['config']['show_place_forecast_in_menu'])) {
            return false;
        }

        return $data['config']['show_place_forecast_in_menu'];
    }

    public static function getWindUnit($slug)
    {
        $data = self::getMineDataBySlug($slug);

        if (!isset($data['config']['wind_unit'])) {
            return 'm/s';
        }

        return $data['config']['wind_unit'];
    }
}
