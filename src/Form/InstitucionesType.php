<?php

namespace App\Form;

use App\Entity\Instituciones;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InstitucionesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('INSTCODE')
            ->add('ACRONYM')
            ->add('OBSERVACIONES')
            ->add('FULL_NAME')
            ->add('TYPE')
            ->add('STREET_POB')
            ->add('CITY_STATE')
            ->add('ZIP_CODE')
            ->add('PHONE')
            ->add('FAX')
            ->add('EMAIL')
            ->add('URL')
            ->add('LATITUDE')
            ->add('LONGITUDE')
            ->add('UPDATED_ON')
            ->add('V_INSTCODE')
            ->add('ISO3')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Instituciones::class,
        ]);
    }
}
