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

class AssociateCompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom S1',
                'mapped' => true,
                'empty_data'  => null,
                'attr' => array(
                    'placeholder' => 'IZY CONTRAT',
                ),
                'required'    => false,
            ])
            // ->add('person')
            ->add('companyType', EntityType::class, [
                'label' => 'forme',
                'class' => CompaniesTypes::class,
                'choice_label' => 'name',
                'mapped' => true,
            ])
            ->add('capitalBring', MoneyType::class, [
                'label' => 'Apport S1',
                'mapped' => true,
                'empty_data'  => null,
                'attr' => array(
                    'placeholder' => 30000,
                ),
                'required'    => false,
            ])
            ->add('legalRepresentative', TextType::class, [
                'label' => 'Representant',
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
