<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use AppBundle\Entity\Road;

/**
 * ImportRoad Type
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class ImportRoadType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateObject', null, [
                'required' => true,
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/y',
                'invalid_message' => 'Fecha: formato inválido "{{ value }}". Formato correcto es "DD/MM/YYYY"',
            ])
            ->add('emissionDate', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/y HH:mm',
                'invalid_message' => 'Fecha de emisión: formato inválido "{{ value }}". Formato correcto es "DD/MM/YYYY HH:MM (24H)"',
            ])
            ->add('validityDate', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/y HH:mm',
                'invalid_message' => 'Fecha de validez: formato inválido "{{ value }}". Formato correcto es "DD/MM/YYYY HH:MM (24H)"',
            ])
            ->add('name', null, [
                'required' => false,
            ])
            ->add('transit', null, [
                'required' => false,
            ])
            ->add('index', null, [
                'required' => false,
            ])
            ->add('risk', null, [
                'required' => false,
            ])
            ->add('condition', null, [
                'required' => false,
            ])
            ->add('alert', null, [
                'required' => false,
            ])
            ->add('observations', null, [
                'required' => false,
            ])
            ;
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Road::class,
            'slug_mine' => null
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getBlockPrefix()
    {
        return 'app_import_road';
    }
}
