<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use AppBundle\Entity\MaritimeForecast;

/**
 * ImportMaritimeForecast Type
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class ImportMaritimeForecastType extends AbstractType
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
            ->add('code', null, [
                'required' => false,
            ])
            ->add('synopticSituation', null, [
                'required' => false,
            ])
            ->add('minimumTemperature', NumberType::class, [
                'scale' => 2,
                'required' => false,
            ])
            ->add('maximumTemperature', NumberType::class, [
                'scale' => 2,
                'required' => false,
            ])
            ->add('forecast', null, [
                'required' => false,
            ])
            ->add('seaState', null, [
                'required' => false,
            ])
            ->add('windIntensity', null, [
                'required' => false,
            ])
            ->add('windDirectionAM', null, [
                'required' => false,
            ])
            ->add('windDirectionPM', null, [
                'required' => false,
            ])
            ->add('windDirectionObservation', null, [
                'required' => false,
            ])
            ->add('heightWavesGeneral', null, [
                'required' => false,
            ])
            ->add('heightWavesAM', null, [
                'required' => false,
            ])
            ->add('heightWavesPM', null, [
                'required' => false,
            ])
            ->add('speedWavesAM', null, [
                'required' => false,
            ])
            ->add('speedWavesPM', null, [
                'required' => false,
            ]);
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => MaritimeForecast::class,
            'slug_mine' => null
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getBlockPrefix()
    {
        return 'app_import_maritime_forecast';
    }
}
