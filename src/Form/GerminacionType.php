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
            //->add('fecha_final')
            //->add('num_dias_en_germinar')
            ->add('observaciones')
            //>add('porcentaje_germinacion_muestra')
            //->add('porcentaje_semillas_no_germinadas_muestra')
            //->add('porcentaje_semillas_germinacion_anomala_muestra')
            //->add('porcentaje_semillas_germinacion_enfermas_muestra')
            ->add('temperatura_prueba_germinacion_max')
            ->add('temperatura_prueba_germinacion_min')
            ->add('temperatura_prueba_germinacion_media')
            ->add('humedad_relativa_prueba_germinacion_max')
            ->add('humedad_relativa_prueba_germinacion_min')
            ->add('humedad_relativa_prueba_germinacion_media')
            ->add('metodo_empleado_para_germinar')
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
