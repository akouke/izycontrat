<?php

namespace App\Form;

use App\Entity\AssociateCompanyInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\CompaniesTypes;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class AssociateCompany3Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom société associée 3',
                'mapped' => true,
                'empty_data'  => null,
                'attr' => array(
                    'placeholder' => 'IZY CONTRAT',
                ),
                'required'    => false,
            ])
            // ->add('person')
            ->add('companyType', EntityType::class, [
                'label' => 'forme juridique',
                'class' => CompaniesTypes::class,
                'choice_label' => 'name',
                'mapped' => true,
            ])
            ->add('capitalBring', MoneyType::class, [
                'label' => 'Apport Associé société 3',
                'mapped' => true,
                'empty_data'  => null,
                'attr' => array(
                    'placeholder' => 25000,
                ),
                'required'    => false,
            ])
            ->add('legalRepresentative', TextType::class, [
                'label' => 'Nom representant legal',
                'mapped' => true,
                'empty_data'  => null,
                'attr' => array(
                    'placeholder' => 'Jone Doe',
                ),
                'required'    => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AssociateCompanyInfo::class,
        ]);
    }
}
