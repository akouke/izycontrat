<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class ClientSarlType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prenom',
                'mapped' => true,
                // 'empty_data'  => null,
                'attr' => array(
                    'placeholder' => 'Votre Nom',
                ),
                'required'    => true,
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'mapped' => true,
                // 'empty_data'  => null,
                'attr' => array(
                    'placeholder' => 'Votre Prenom',
                ),
                'required'    => true,
            ])
            ->add('phoneNumber', TelType::class, [
                'label' => 'Téléphone',
                'mapped' => true,
                'empty_data'  => null,
                'attr' => array(
                    'placeholder' => 'Votre numero de telephone',
                ),
                'required'    => false,
            ])
            // ->add('gender')
            // ->add('address')
            // ->add('country')
            // ->add('capitalAmountAdding')
            // ->add('hasCompany')
            // ->add('score')
            // ->add('specialization')
            // ->add('user')
            // ->add('companies')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }
}
