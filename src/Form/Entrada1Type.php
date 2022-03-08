<?php

namespace App\Form;

use App\Entity\Entrada;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Entrada1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('cantidad')
        ->add('fecha_entrada', DateType::class, [
            'widget' => 'single_text',
        ])
        ->add('tipo_entrada', ChoiceType::class, [
            'choices'  => [
                'Nueva' => 'Nueva',
                'Devolución' => 'Devolución',
                'Renovación' => 'Renovación',
            ],
        ])
        ->add('observaciones')
        ->add('codigoEntrada', IntegerType::class, [
            'required' => true,
            'attr' => [
                'placeholder' => '00000'
            ]
        ])
        ->add('numPasaporte')
        ->add('cantidadUnidades')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entrada::class,
        ]);
    }
}
