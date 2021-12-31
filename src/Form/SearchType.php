<?php

namespace App\Form;

use App\Utils\Utilities;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    
    protected $util;   
        
       function __construct(Utilities $utility){
            
          $this->util = $utility;
             
       }
       
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $rgcs = $this->util;
        $row = 'rgcs__srch-row';
        
        // Loads all translations
        $polinizacion = $rgcs->multiOptions('tipoPolinizacion');
        // $tipoSiembra = $rgcs->multiOptions('tipoSiembra');

        
        $builder
        
            ->add('familia', TextType::class, [
                'label' => false,
                'attr' =>['placeholder'=> 'Familia'],
                'row_attr' => ['class'=>$row],
                // 'help' => 'Esto es una ayuda',
                'required'=>false]
            )
            /*->add('formaSiembra', ArrayType::class,  [
                'label' => $rgcs->lang('tipoSiembra.label'),
                'choices' => [
                        $tipoSiembra[0] => $tipoSiembra[0],
                        $tipoSiembra[1] => $tipoSiembra[1],
                        $tipoSiembra[2] => $tipoSiembra[2],
                        ],
                'multiple' => false,
                'expanded' => false,
                'mapped' => true,
                'row_attr' => ['class'=>$row],
            ])*/       
            ->add('especie', TextType::class, [
                'label' => false,
                'attr' =>['placeholder'=> 'Especie'],
                'row_attr' => ['class'=>$row],
                'required'=>false
            ])
            ->add('genero', TextType::class,[
                'label' => false,
                'attr' =>['placeholder'=> 'Género'],
                'row_attr' => ['class'=>$row],
                'required'=>false
            ])
            ->add('nombreComun', TextType::class, [
                'label' => false,
                'attr' =>['placeholder'=> 'Nombre Común'],
                'row_attr' => ['class'=>$row],
                'required'=>false
            ])
            ->add('polinizacion', ChoiceType::class,  [
                'label' => false,
                'placeholder' => false,
                'choices' => ['Polinización'=>'','Alógama'=>'Alógama','Autógama'=>'Autógama','Mixta'=>'Mixta'],
                'choice_attr' => ['Polinización' => ['disabled'=>'']],
                'multiple' => false,
                'expanded' => false,
                'mapped' => true,
                'row_attr' => ['class'=>$row],
				'required'=>false,
            ])
            ->add('search', TextType::class,
                [   'label' => false,
                    'attr' =>['placeholder'=> 'Buscar'],
                    'row_attr' => ['class'=>$row],
                    'required'=>false]
            )
            // ->add('save', TextType::class,
            //     [   'label' => false,
            //         'attr' =>['placeholder'=> 'Buscar'],
            //         'row_attr' => ['class'=>$row],
            //         'required'=>false]
            // )
            // ->add('download', TextType::class,
            //     [   'label' => false,
            //         'attr' =>['placeholder'=> 'Buscar'],
            //         'row_attr' => ['class'=>$row],
            //         'required'=>false]
            // )
            
            ->add('submit', SubmitType::class,
                ['label'=> 'Buscar',
                    'row_attr' => ['class'=>$row]
            ]
            )  
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
