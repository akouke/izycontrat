<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class Associate2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('capitalAmountAdding', MoneyType::class, [
                'label' => 'Apport Associé(e)2',
                'mapped' => true,
                'empty_data'  => null,
                'attr' => array(
                    'placeholder' => 50000,
                ),
                'required'    => false,
            ])
             ->add('firstName', TextType::class, [
                'label' => 'Prénom Associé(e)2',
                'mapped' => true,
                'empty_data'  => null,
                'attr' => array(
                    'placeholder' => 'Adrien',
                ),
                'required'    => false,
            ])
            ->add('lastName',  TextType::class, [
                'label' => 'Nom Associé(e)2',
                'mapped' => true,
                'empty_data'  => null,
                'attr' => array(
                    'placeholder' => 'Durand',
                ),
                'required'    => false,
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'M/Mm Associé(e)2',
                // 'expanded' => true,
                'choices' => [
                                'Monsieur' => 2,
                                'Madame' => 1,
                            ],
                'mapped' => true,
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
