<?php

namespace AppBundle\Form\Admin;

use AppBundle\Model\Helper\SynopticSituationHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * SynopticIconType.
 *
 * @author mati
 */
class SynopticIconType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label' => 'Icono',
            'required' => false,
            'placeholder' => 'Seleccionar ícono',
            'choices' => SynopticSituationHelper::iconChoices(),
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
