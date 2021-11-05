<?php

namespace App\Form;

use App\Entity\Persona;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Persona2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('num_socio')
            ->add('fecha_inscripcion_rgcs', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('acepta_condiciones')
            ->add('tipo_socio')
            ->add('ampliacion_cuota')
            ->add('fecha_cuota', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('recibir_informacion')
            ->add('fecha_informacion', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('nif')
            ->add('nombre')
            ->add('apellidos')
            ->add('direccion')
            ->add('localidad')
            ->add('municipio')
            ->add('provincia')
            ->add('region')
            ->add('pais_origen')
            ->add('telefono')
            ->add('telefono2')
            ->add('correo')
            ->add('relacion_agricultura')
            ->add('terreno_cultivo')
            ->add('inscripcion_rope')
            ->add('codigo_rope')
            ->add('otras_cuestiones')
            ->add('documento')
            ->add('observaciones')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Persona::class,
        ]);
    }
}
