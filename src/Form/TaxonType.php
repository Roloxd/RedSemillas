<?php

namespace App\Form;

use App\Entity\Taxon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaxonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tipo')
            ->add('nombre')
            ->add('padre')
            ->add('autoridad')
            ->add('subtaxon')
            ->add('autoridad_subtaxon')
            ->add('observaciones')
            ->add('descripcion')
            // ->add('variedad')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Taxon::class,
        ]);
    }
}
