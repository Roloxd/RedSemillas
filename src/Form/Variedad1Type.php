<?php

namespace App\Form;

use App\Entity\Variedad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Variedad1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add('nombreComun')
            ->add('nombreLocal')
            ->add('especie')
            ->add('tipoSiembra')
            ->add('diasSemillero')
            ->add('marcoA')
            ->add('marcoB')
            ->add('densidad')
            ->add('cicloCultivo')
            ->add('polinizacion')
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
            ->add('observaciones')
            ->add('usoVariedad')
            ->add('imagenSeleccionada')
            ->add('cicloYSiembras')
            ->add('subtaxon')
        ;
    }

    public function configureOptions(OptionsResolver $resolver) : void
    {
        $resolver->setDefaults([
            'data_class' => Variedad::class,
        ]);
    }
}
