<?php

namespace AppBundle\Form;

use AppBundle\Entity\HourMeteorologicalForecast;
use AppBundle\Model\Helper\ConfigHelper;
use AppBundle\Model\Helper\SynopticSituationHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * ImportHourMeteorologicalForecast Type.
 *
 * @author jcordova <jhonny.cordova@dsarhoya.cl>
 */
class ImportHourMeteorologicalForecastType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('place', ChoiceType::class, [
                'choices' => array_flip(ConfigHelper::getPlaceChoicesBySlug($options['slug_mine'])),
                'required' => true,
                'invalid_message' => 'Este valor "{{ value }}" no es válido, las opciones  validas son: '.implode(', ', array_values(ConfigHelper::getPlaceChoicesBySlug($options['slug_mine']))),
            ])
            ->add('date', DateTimeType::class, [
                'required' => true,
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/y HH:mm',
                'invalid_message' => 'Fecha: formato inválido "{{ value }}". Formato correcto es "DD/MM/YYYY"',
            ])
            ->add('cloudCoverIcon', ChoiceType::class, [
                'required' => false,
                'choices' => SynopticSituationHelper::iconChoices(),
                'invalid_message' => 'Este valor "{{ value }}" no es válido, las opciones  validas son: '.implode(', ', array_values(SynopticSituationHelper::iconChoices())),
            ])
            ->add('windDirection', null, [
                'required' => false,
            ])
            ->add('windIntensity', null, [
                'required' => false,
            ])
            ->add('windGusts', null, [
                'required' => false,
            ])
            ->add('temperature', null, [
                'required' => false,
            ])
            ->add('thermalSensation', null, [
                'required' => false,
            ])
            ->add('relativeHumidity', null, [
                'required' => false,
            ])
            ->add('precipitationProbability', null, [
                'required' => false,
            ])
            ->add('estimatedAccumulation', null, [
                'required' => false,
            ])
            ->add('electricalActivityProbability', null, [
                'required' => false,
            ])
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HourMeteorologicalForecast::class,
            'slug_mine' => null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_import_hour_meteorological_forecast';
    }
}
