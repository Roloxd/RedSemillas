<?php

namespace App\Form;

use App\Entity\Envase;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnvaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha_envasado', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('ubicacion_envase')
            ->add('cantidad_gramos')
            ->add('cantidad_unidades')
            ->add('unidades_viables')
            ->add('temperatura_envasado')
            ->add('humedad_relativa_envasar')
            ->add('humedad_relativa_semilla')
            ->add('cantidad_min_seguridad')
            ->add('cantidad_min_unidades')
            ->add('unidades_gramo')
            ->add('disponibilidad_red')
            ->add('conservacion')
            ->add('observaciones')
            ->add('variedads')
            ->add('datos_ancestrales')
            ->add('codigo')
            ->add('tipo_almacenamiento')
            ->add('entrada')
            ->add('condicion_biologica')
            ->add('fuente_recoleccion')
            ->add('estado_accesion_mls')
            ->add('fecha_recoleccion', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('fechaObtencion', DateType::class, [
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Envase::class,
        ]);
    }
}
