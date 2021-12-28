<?php

namespace App\Form;

use App\Entity\Variedad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Variedad1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add('nombreComun')
            ->add('nombreLocal')
            ->add('tipoSiembra', ChoiceType::class, [
                'placeholder' => 'Selecciona tipo de siembra',
                'choices'  => [
                    'Directa' => 'Directa',
                    'Semillero' => 'Semillero',
                    'Voleo' => 'Voleo',
                ],
            ])
            ->add('diasSemillero')
            ->add('descripcion', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
                'required' => false,
            ])
            ->add('marcoA')
            ->add('marcoB')
            ->add('densidad')
            ->add('cicloCultivo')
            ->add('polinizacion', ChoiceType::class, [
                'placeholder' => 'Selecciona polinización',
                'choices'  => [
                    'Alógama' => 'Alógama',
                    'Autógama' => 'Autógama',
                    'Mixta ' => 'Mixta ',
                ],
            ])
            ->add('caracterizacion')
            ->add('viabilidadMin')
            ->add('viabilidadMax')
            ->add('conocimientosTradicionales')
            ->add('cmPlanta')
            ->add('cmFlor')
            ->add('cmFruto')
            ->add('cmSemilla')
            ->add('cArgonomicas')
            ->add('cOrganolepticas')
            ->add('propagacion')
            ->add('otros')
            ->add('observaciones', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
                'required' => false,
            ])
            ->add('breveDescrPlantaCultivo')
            ->add('codigo')
            ->add('manejoCultivo', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
                'required' => false,
            ])
            ->add('manejoSiembraPlantacion', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
                'required' => false,
            ])
            ->add('manejoSueloDesherbado', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
                'required' => false,
            ])
            ->add('manejoAsociacionRotacionCultivos', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
                'required' => false,
            ])
            ->add('manejoPodaEntutorado', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
                'required' => false,
            ])
            ->add('manejoAbonadoRiego', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
                'required' => false,
            ])
            ->add('manejoPlagasEnfermedades', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
                'required' => false,
            ])
            ->add('manejoCosechaConservacion', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
                'required' => false,
            ])
            
            //->add('cicloYSiembras')
            // ->add('especie')
        ;
    }

    public function configureOptions(OptionsResolver $resolver) : void
    {
        $resolver->setDefaults([
            'data_class' => Variedad::class,
        ]);
    }
}
