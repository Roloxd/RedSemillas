<?php

namespace App\Form;

use App\Entity\Pago;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PagoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fechaRenovacion', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
            ])
            ->add('fechaPago', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                'empty_data' => '01-01-0001',
            ])
            ->add('persona')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pago::class,
        ]);
    }
}
