<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AssociatePersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('firstName')
            // ->add('lastName')
            // ->add('phoneNumber')
            // ->add('address')
            // ->add('country')
            // ->add('hasCompany')
            // ->add('score')
            // ->add('specialization')
            // ->add('user')
            // ->add('companies')
            // ->add('gender', RadioType::class, [
            //     'label' => 'Civilite',
            //     'mapped' => true,
            //     'empty_data'  => null,
            //     'required'    => false,
            // ])
            ->add('capitalAmountAdding', MoneyType::class, [
                'label' => 'Apport Associé',
                'mapped' => true,
                'empty_data'  => null,
                'attr' => array(
                    'placeholder' => 30000,
                ),
                'required'    => false,
            ])
             ->add('firstName', TextType::class, [
                'label' => 'Prénom Associé',
                'mapped' => true,
                'empty_data'  => null,
                'attr' => array(
                    'placeholder' => 'Abdoulaye',
                ),
                'required'    => false,
            ])
            ->add('lastName',  TextType::class, [
                'label' => 'Nom Associé',
                'mapped' => true,
                'empty_data'  => null,
                'attr' => array(
                    'placeholder' => 'SECK',
                ),
                'required'    => false,
            ])
             ->add('gender', ChoiceType::class, [
                'label' => 'M/Mm',
                // 'expanded' => true,
                'choices' => [
                                'Monsieur' => 2,
                                'Madame' => 1,
                            ],
                'mapped' => true,
            ])
            // ->add('tags', CollectionType::class, [
            //         'entry_type' => PersonType::class,
            //         'entry_options' => ['label' => false],
            //         'allow_add' => true,
            //     ])
            // ->add('phoneNumber', TelType::class, [
            //     'label' => 'Téléphone',
            //     'mapped' => true,
            //     'empty_data'  => null,
            //     'attr' => array(
            //         'placeholder' => '0X XX XX XX XX',
            //     ),
            //     'required'    => false,
            // ])
            // ->add('address', TextareaType::class, [
            //     'label' => 'Adresse',
            //     'mapped' => true,
            //     'empty_data'  => null,
            //     'attr' => array(
            //         'placeholder' => '15 rue de la patte d\'oie 78000 Versailles',
            //     ),
            //     'required'    => false,
            // ])
            // ->add('country', CountryType::class, [
            //     'label' => 'Pays',
            //     'mapped' => true,
            //     'empty_data'  => null,
            //     'preferred_choices' => array('FR'),
            //     'required'    => true,
            //     'constraints' => [
            //         new NotBlank([
            //             'message' => 'Le Pays ne doit pas être vide.',
            //         ]),
            //     ],
            // ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }
}
