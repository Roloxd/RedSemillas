<?php

namespace App\Form;

use App\Entity\Donante;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DonanteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tipo_donante')
            ->add('instcode')
            ->add('proyecto')
            ->add('num_accesion_donante')
            ->add('observaciones')
            ->add('persona')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Donante::class,
        ]);
    }
}
