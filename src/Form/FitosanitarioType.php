<?php

namespace App\Form;

use App\Entity\Entrada;
use App\Entity\Fitosanitario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FitosanitarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->add('fecdetpat', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('obs', TextareaType::class, [
                'attr' => [
                    'maxlength' => 50
                ],
                'required' => false,
            ])
            ->add('envase')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fitosanitario::class,
        ]);
    }
}
