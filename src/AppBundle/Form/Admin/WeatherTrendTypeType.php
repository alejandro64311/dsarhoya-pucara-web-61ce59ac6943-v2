<?php

namespace AppBundle\Form\Admin;

use AppBundle\Entity\WeatherTrend;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * WeatherTrendTypeType.
 *
 * @author mati
 */
class WeatherTrendTypeType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label' => 'Tipo',
            'choices' => WeatherTrend::typeChoices(),
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
