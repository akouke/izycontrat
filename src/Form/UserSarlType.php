<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class UserSarlType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Mail',
                'mapped' => true,
                // 'empty_data'  => null,
                'attr' => array(
                    'placeholder' => 'votre addresse mail',
                ),
                'required'    => true,
            ])
            // ->add('password', HiddenType::class, [
            //     'mapped' => false,
            //     'data'  => "password",
                // 'empty_data'  => "password",
                // 'required'    => true,
            // ])
            // ->add('isVerified', HiddenType::class, [
            //     'mapped' => false,
            //     'data'  => true,
            // ])
            // ->add('roles', HiddenType::class, [
            //         'mapped' => false,
            //         'data' => '["ROLE_CLIENT"]',
            //     ]);
            // ->add('profilePicture')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
