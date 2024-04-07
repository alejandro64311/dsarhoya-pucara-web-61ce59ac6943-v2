<?php

namespace AppBundle\Form\Admin;

use AppBundle\Entity\Link;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * LinkTypeType.
 *
 * @author mati
 */
class LinkTypeType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label' => 'Tipo',
            'choices' => Link::typeChoices(),
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
