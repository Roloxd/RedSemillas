<?php

namespace App\Form\Type;

use App\Form\DataTransformer\ArrayTransformer;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\VarDumper\VarDumper;

class SalidaNumberType extends AbstractType
{
    private $transformer;

    public function __construct(ArrayTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //VarDumper::dump($this->transformer);	
        $builder->addModelTransformer(new CallbackTransformer(
            function ($tagsAsArray) {
                // transform the array to a string
                return 'hola';
            },
            function ($tagsAsString) {
                // transform the string back to an array
                return $tagsAsString;
            })
        );


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'invalid_message' => 'The selected issue does not exist',
        ]);
    }

    public function getParent(): string
    {
        return TextType::class;
    }
}
