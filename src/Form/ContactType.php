<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Contact;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'attr' => ['class' => "w-100 mb-3 p-3", 'placeholder' => "Jacques"],
                'label' => 'Prénom',
            ])
            ->add('lastname', TextType::class, [
                'attr' => ['class' => "w-100 mb-3 p-3", 'placeholder' => "Dubois"],
                'label' => 'Nom',
            ])
            ->add('phone', TextType::class, [
                'attr' => ['class' => "w-100 p-3", 'placeholder' => "0687654321"],
                'label' => 'Numéro de téléphone',
                'help' => "Votre numéro de téléphone doit être composé de 10 chiffres seulement.",
                'required' =>false,
            ])
            ->add('email', EmailType::class, [
                'attr' => ['class' => "w-100 p-3", 'placeholder' => "jacques.dubois@gmail.com"],
                'label' => 'Adresse Email',
                'help' => "Veuillez entrer une adresse e-mail valide.",
            ])
            ->add('message', TextareaType::class, [
                'attr' => ['class' => "w-100 p-3", 'style' => "height : 200px",
                    'placeholder' =>
                        "Votre message ici"],
                'label' => 'Message',
                'help' => "Votre message doit être composé de 20 caractères minimum.",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
