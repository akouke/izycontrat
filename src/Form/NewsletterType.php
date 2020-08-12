<?php

namespace App\Form;

use App\Entity\EmailNewsletter;
use App\Entity\Newsletter;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsletterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject', TextType::class, [
                'label' => 'object' ,
                'attr' => [
                    'placeholder' => 'Veuillez renseigner l\'objet du mail'
                ]])
            ->add('post', CKEditorType::class, [
                'label' => 'Newsletter'])
//            ->add('date')
//            ->add('emails', EntityType::class, [
//                'class' => EmailNewsletter::class,
//                'choice_label' => 'email',
//                'multiple' => true,
//                'expanded' => true,
//                'by_reference' => false,
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Newsletter::class,
        ]);
    }
}
