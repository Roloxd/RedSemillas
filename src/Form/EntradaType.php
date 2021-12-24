<?php

namespace App\Form;

use App\Entity\Entrada;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntradaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codigo_entrada')
            ->add('num_pasaporte')
            ->add('num_envase')
            ->add('cantidad')
            ->add('superficie_cultivo')
            ->add('fecha_entrada')
            ->add('tipo_entrada')
            ->add('observaciones')
            //->add('id_terreno')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entrada::class,
        ]);
    }
}
