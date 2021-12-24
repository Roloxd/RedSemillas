<?php

namespace App\Form;

use App\Entity\Entrada;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
                    'Nueva' => 1,
                    'Devolución' => 2,
                    'Renovación' => 3,
                ],
            ])
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
