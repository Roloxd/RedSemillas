<?php

namespace App\Form;

use App\Entity\ImagenSeleccionada;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImagenSeleccionadaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tipo', ChoiceType::class, [
                'placeholder' => 'Selecciona tipo',
                'choices'  => [
                    'Planta' => 'Planta',
                    'Flor' => 'Flor',
                    'Fruto' => 'Fruto',
                    'Semilla' => 'Semilla',
                ],
            ])
            //->add('imagen')
            ->add('variedad')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ImagenSeleccionada::class,
        ]);
    }
}
