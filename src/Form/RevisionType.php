<?php

namespace App\Form;

use App\Entity\Revision;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RevisionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha_revision', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('semillas_muertas')
            ->add('semillas_germinadas')
            ->add('semillas_no_germinadas')
            ->add('semillas_anomalas')
            ->add('semillas_enfermas')
            ->add('germinacion')
            ->add('temperatura_max')
            ->add('temperatura_min')
            ->add('humedad_max')
            ->add('humedad_min')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Revision::class,
        ]);
    }
}
