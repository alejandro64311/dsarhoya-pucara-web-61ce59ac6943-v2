<?php

namespace AppBundle\Model\Helper;

use Symfony\Component\HttpFoundation\RequestStack;

class SynopticSituationHelper
{
    const ICONS = [
        'PARCIAL_NUBLADO_NOCHE.png',
        'AGUA_NIEVE.png',
        'CHUBASCOS_AGUA_DIA.png',
        'CHUBASCOS_AGUA_NOCHE.png',
        'CHUBASCOS_DIA_2.png',
        'CHUBASCOS_NOCHE_2.png',
        'CUBIERTO.png',
        'DESPEJADO_DIA.png',
        'DESPEJADO_NOCHE.png',
        'ELECTRICA_DIA_2.png',
        'ELECTRICA_DIA_3.png',
        'ELECTRICA_INTENSA.png',
        'ELECTRICA_NOCHE_1.png',
        'ELECTRICA_NOCHE_2.png',
        'ELECTRICAD_DIA_1.png',
        'GRANIZO.png',
        'LLOVIZNA.png',
        'LLUVIA_DEBIL.png',
        'LLUVIA_INTENSA.png',
        'NEBLINA_DIA.png',
        'NEBLINA_NOCHE.png',
        'NEVADA_INTENSA.png',
        'NEVADA_MODERADA.png',
        'NEVADAS_DIA_3.png',
        'NEVADAS_NOCHE_3.png',
        'NIEBLA_DIA.png',
        'NIEBLA_NOCHE.png',
        'NIEVE_DIA_1.png',
        'NIEVE_DIA_2.png',
        'NIEVE_NOCHE_1.png',
        'NIEVE_NOCHE_2.png',
        'DESCONOCIDO.png',
        'ESCASA_NUBOSIDAD_DIA.png',
        'ESCASA_NUBOSIDAD_NOCHE.png',
        'NUBLADO_DIA.png',
        'NUBLADO_NOCHE.png',
        'PARCIAL_DIA.png',
        'PARCIAL_NOCHE.png',
        'PARCIAL_NUBLADO_DIA.png',

        //Viejos
        'chubascos.png',
        'lluvia.png',
        'niebla.png',
        'nieve.png',
        'nublado.png',
        'parcialmente nublado.png',
        'soleado.png',
        'tormenta.png',
    ];

    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public static function iconNames()
    {
        $names = array_map(function ($iconName) {
            $parts = explode('.', $iconName);

            return array_shift($parts);
        }, self::ICONS);

        return $names;
    }

    public static function iconChoices()
    {
        $names = self::iconNames();

        return array_combine($names, $names);
    }

    public function urlForIconNamed($iconName)
    {
        if (!in_array($iconName, self::iconNames())) {
            return null;
        }

        return $this->requestStack->getMasterRequest()->getUriForPath("/assets/icons/{$iconName}.png");
    }
}
