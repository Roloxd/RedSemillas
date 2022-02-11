<?php

namespace App\Form;

use App\Entity\Germinacion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GerminacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha_inicio', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('num_semillas_para_prueba')
            ->add('observaciones')
            // ->add('metodo_empleado_para_germinar')
            ->add('envase')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Germinacion::class,
        ]);
    }
}
