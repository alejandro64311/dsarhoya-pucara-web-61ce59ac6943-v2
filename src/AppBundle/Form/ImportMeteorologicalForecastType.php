<?php

namespace AppBundle\Form;

use AppBundle\Entity\MeteorologicalForecast;
use AppBundle\Model\Helper\ConfigHelper;
use AppBundle\Model\Helper\SynopticSituationHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * ImportMeteorologicalForecast Type.
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class ImportMeteorologicalForecastType extends AbstractType
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
            ->add('synopticSituation', null, [
                'required' => false,
            ])
            ->add('visibility', null, [
                'required' => false,
            ])
            ->add('generalWeather', null, [
                'required' => false,
            ])
            ->add('weatherAM', null, [
                'required' => false,
            ])
            ->add('weatherPM', null, [
                'required' => false,
            ])
            ->add('generalWeatherIcon', ChoiceType::class, [
                'required' => false,
                'choices' => SynopticSituationHelper::iconChoices(),
                'invalid_message' => 'Este valor "{{ value }}" no es válido, las opciones  validas son: '.implode(', ', array_values(SynopticSituationHelper::iconChoices())),
            ])
            ->add('weatherAMIcon', ChoiceType::class, [
                'required' => false,
                'choices' => SynopticSituationHelper::iconChoices(),
                'invalid_message' => 'Este valor "{{ value }}" no es válido, las opciones  validas son: '.implode(', ', array_values(SynopticSituationHelper::iconChoices())),
            ])
            ->add('weatherPMIcon', ChoiceType::class, [
                'required' => false,
                'choices' => SynopticSituationHelper::iconChoices(),
                'invalid_message' => 'Este valor "{{ value }}" no es válido, las opciones  validas son: '.implode(', ', array_values(SynopticSituationHelper::iconChoices())),
            ])
            ->add('minimumTemperature', NumberType::class, [
                'scale' => 2,
                'required' => false,
            ])
            ->add('maximumTemperature', NumberType::class, [
                'scale' => 2,
                'required' => false,
            ])
            ->add('isotherm', NumberType::class, [
                'scale' => 2,
                'required' => false,
            ])
            ->add('windDirectionAM', null, [
                'required' => false,
            ])
            ->add('windDirectionPM', null, [
                'required' => false,
            ])
            ->add('maximumGustWind', null, [
                'required' => false,
            ])
            ->add('windUnid', ChoiceType::class, [
                'choices' => MeteorologicalForecast::getChoicesWindUnid(),
            ])
            ->add('uvRadiation', null, [
                'required' => false,
            ])
            ->add('uvRadiationMapUrl', null, [
                'required' => false,
            ])
            ->add('rainLast24hours', NumberType::class, [
                'scale' => 2,
                'required' => false,
            ])
            ->add('rainAccumulated', NumberType::class, [
                'scale' => 2,
                'required' => false,
            ])
            ->add('rainNormal', NumberType::class, [
                'scale' => 2,
                'required' => false,
            ])
            ->add('rainSurplusDeficit', NumberType::class, [
                'scale' => 2,
                'required' => false,
                ])
            ->add('rainProbability', NumberType::class, [
                'scale' => 2,
                'required' => false,
            ])
            ->add('electricActivity', NumberType::class, [
                'scale' => 2,
                'required' => false,
            ])
            ->add('snowLast24hours', NumberType::class, [
                'scale' => 2,
                'required' => false,
            ])
            ->add('snowAccumulated', NumberType::class, [
                'scale' => 2,
                'required' => false,
            ])
            ->add('snowNormal', NumberType::class, [
                'scale' => 2,
                'required' => false,
            ])
            ->add('snowSurplusDeficit', NumberType::class, [
                'scale' => 2,
                'required' => false,
            ])
            ->add('snowProbability', NumberType::class, [
                'scale' => 2,
                'required' => false,
            ])
            ->add('satelitalImageUrl', null, [
                'required' => false,
            ])
            ->add('seaConditions', null, [
                'required' => false,
            ])
            ->add('humidity', NumberType::class, [
                'scale' => 2,
                'required' => false,
            ])
            ->add('maximumHumidity', NumberType::class, [
                'scale' => 2,
                'required' => false,
            ])
            ->add('soilFreezing', CheckboxType::class, [
                'required' => false,
            ])
            ->add('description', null, [
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
            'data_class' => MeteorologicalForecast::class,
            'slug_mine' => null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_import_meteorological_forecast';
    }
}
