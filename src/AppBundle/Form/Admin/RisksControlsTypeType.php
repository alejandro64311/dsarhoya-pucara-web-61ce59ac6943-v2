<?php

namespace AppBundle\Form\Admin;

use AppBundle\Entity\RisksControls;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * RisksControls Type Type.
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class RisksControlsTypeType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'placeholder' => 'Seleccione...',
            'choices' => array_flip(RisksControls::getTypes()),
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
