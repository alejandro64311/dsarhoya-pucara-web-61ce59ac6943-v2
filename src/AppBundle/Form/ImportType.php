<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Description of ImportType
 *
 * @author snake77se at dsarhoya.cl
 */
class ImportType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("file", FileType::class, [
                "label" => "Seleccione el archivo xls",
                'required' => false,
                "constraints" => array(
                    new \Symfony\Component\Validator\Constraints\NotNull(["message" => "Debe cargar el archivo"]),
                    new \Symfony\Component\Validator\Constraints\File([
//                        'mimeTypes'=>[
//                            "application/vnd.ms-excel",
//                            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
//                            "application/vnd.oasis.opendocument.spreadsheet"
//                        ],
//                        'mimeTypesMessage'=>'Tipo de archivo incorrecto. solo extensiones xls, xlsx, ods.',
                        'maxSize' => '10M',
                        'maxSizeMessage' => 'Archivo sobrepasa el tamaño permitido.'
                    ])
                )
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_import';
    }
}
