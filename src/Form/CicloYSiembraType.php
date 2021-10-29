<?php

namespace App\Form;

use App\Entity\CicloYSiembra;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CicloYSiembraType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('altitud')
            ->add('zona')
            ->add('coordenadas')
            ->add('ciclo')
            ->add('enero')
            ->add('febrero')
            ->add('marzo')
            ->add('abril')
            ->add('mayo')
            ->add('junio')
            ->add('julio')
            ->add('agosto')
            ->add('septiembre')
            ->add('octubre')
            ->add('noviembre')
            ->add('diciembre')
            ->add('variedad')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CicloYSiembra::class,
        ]);
    }
}
