<?php

namespace App\Form;

use App\Entity\Terreno;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TerrenoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('direccion')
            ->add('nombre')
            ->add('datos_sigpac')
            ->add('localizacion_mapa')
            ->add('superficie_finca')
            ->add('superficie_cultivo')
            ->add('manejo_cultivo')
            ->add('tipo_cultivos')
            ->add('observaciones')
            //->add('id_persona')
            ->add('localidad')
            ->add('municipio')
            ->add('provincia')
            ->add('region')
            ->add('pais_origen')
            ->add('persona_propietaria')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Terreno::class,
        ]);
    }
}
