<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class Associate1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $choices = [
        //     'M' => 'M',
        //     'Mm' => 'Mm'
        // ];
        $builder
          ->add('capitalAmountAdding', MoneyType::class, [
                'label' => 'Apport Associé 1',
                'mapped' => true,
                'empty_data'  => null,
                'attr' => array(
                    'placeholder' => 30000,
                ),
                'required'    => false,
            ])
             ->add('firstName', TextType::class, [
                'label' => 'Prénom Associé 1',
                'mapped' => true,
                'empty_data'  => null,
                'attr' => array(
                    'placeholder' => 'Saliha',
                ),
                'required'    => false,
            ])
            ->add('lastName',  TextType::class, [
                'label' => 'Nom Associé 1',
                'mapped' => true,
                'empty_data'  => null,
                'attr' => array(
                    'placeholder' => 'AZOUGAGH',
                ),
                'required'    => false,
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Civilite',
                // 'expanded' => true,
                'choices' => [
                                'Monsieur' => 2,
                                'Madame' => 1,
                            ],
                'mapped' => true,
                // 'empty_data'  => null,
                // 'choice_value' => 'M'
                // 'required'    => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }
}
