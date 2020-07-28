<?php

namespace App\Form;

use App\Entity\AssociateCompanyInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\CompaniesTypes;

class AssociateCompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom Societe Associe 1',
                'mapped' => true,
                'empty_data'  => null,
                'attr' => array(
                    'placeholder' => 'IZY CONTRAT',
                ),
                'required'    => false,
            ])
            // ->add('person')
            ->add('companyType', EntityType::class, [
                'class' => CompaniesTypes::class,
                'choice_label' => 'name',
                'mapped' => true,
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
