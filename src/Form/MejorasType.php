<?php

namespace App\Form;

use App\Entity\Mejoras;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MejorasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('metodoMejora')
            ->add('descripcionProcedimiento')
            ->add('imagenesProceso')
            ->add('observaciones', TextareaType::class, [
                'attr' => [
                    'maxlength' => 50
                ],
                'required' => false,
            ])
            ->add('instituciones')
            ->add('personas')
            ->add('entrada')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mejoras::class,
        ]);
    }
}
