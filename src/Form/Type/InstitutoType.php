<?php

namespace App\Form\Type;

use App\Entity\Instituto;

use App\Form\DataTransformer\ArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\VarDumper\VarDumper;

class InstitutoType extends AbstractType
{
    private $transformer;

    public function __construct(ArrayTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //VarDumper::dump($options);
        $builder->addModelTransformer(new CallbackTransformer(
                function ($string) {
                    // GET from Entity transform the array to a string
                    //VarDumper::dump($string);

                    if($string != null || $string != ''){
                        $decode = json_decode($string, true);
                        //VarDumper::dump($decode);
                        return $decode;
                    }
                },
                function ($string) {
                    // SET to Entity transform the string back to an array
                    //VarDumper::dump($string);
                    if($string != null || $string != ''){
                        return $string;
                    }
                })
        );;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'invalid_message' => 'The selected issue does not exist',
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}
