<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\CompaniesTypes;
use App\Entity\Priority;
use App\Entity\ActivitySector;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\CompaniesTypesRepository;
use App\Repository\PriorityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class CompanyType extends AbstractType
{
    private $companiesTypesRecup;
    private $priorityRecup;
    
    public function __construct(CompaniesTypesRepository $companiesRecup, PriorityRepository $priorityRecup)
    {
        $this->companiesTypesRecup = $companiesRecup;
        $this->priorityRecup = $priorityRecup;
        
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('regimeMicroEntreprise', CheckboxType::class, [
                'required' => false,
                'mapped' => true,
                ])
            ->add('addressManager', TextType::class, [
                'attr' => [
                    'placeholder' => "Quel est l’adresse du Gérant ?"
                    ],
                'required' => false,
                'mapped' => true,
                ])
            ->add('name', TextType::class, [
                'attr' => [
                    'placeholder' => "nom entreprise"
                    ],
                 'required' => false,
                 'mapped' => true,
                ])
            // ->add('isCreated')
            ->add('manager', ChoiceType::class, [
                'choices' => [
                    'OUI' => 'Oui',
                    'NON' => 'Non',
                    'JE NE SAIS PAS' => 'Je ne sais pas'
                    ],
                // 'required' => false,
                'mapped' => true,
                ])
            ->add('tradeName', TextType::class, [
                'attr' => [
                    'placeholder' => " Nom Commercial"
                    ],
                'required' => false,
                'mapped' => true,
                ])
            ->add('hasProtection', ChoiceType::class, [
                'choices' => [
                    'OUI' => 'Oui',
                    'NON' => 'Non',
                    'PLUS TARD' => 'Plus tard'
                    ],
                // 'required' => false,
                'mapped' => true,
                ])
            ->add('hasAssociate', ChoiceType::class, [
                'choices' => [
                    'OUI' => 'Oui',
                    'NON' => 'Non',
                    'PLUS TARD' => 'Plus tard'
                    ],
                // 'required' => false,
                'mapped' => true,
                ])
            ->add('hasDirector', ChoiceType::class, [
                'choices' => [
                    'OUI' => 'Oui',
                    'NON' => 'Non',
                    'JE NE SAIS PAS' => 'Je ne sais pas'
                    ],
                // 'required' => false,
                'mapped' => true,
                ])
            // ->add('headOffice')
            // ->add('associates')
            ->add('bankName', TextType::class, [
                'attr' => [
                    'placeholder' => " Nom de la Banque :"
                    ],
                'required' => false,
                'mapped' => true,
                ])
            ->add('capitalSocial', MoneyType::class, [
                'attr' => [
                    'placeholder' => "2000 EURO"
                    ],
                'required' => false,
                'mapped' => true,
                ])
            ->add('address', TextType::class, [
                'attr' => [
                    'placeholder' => "Veuillez préciser l'adresse :"
                    ],
                'required' => false,
                'mapped' => true,
                ])
            ->add('country', TextType::class, [
                'attr' => [
                    'placeholder' => "Dans quel département ?"
                    ],
                'required' => false,
                'mapped' => true,
                ])
            // ->add('president')
            // ->add('generalDirector', EntityType::class, [
            //     'class' => User::class,
            //     'query_builder' => function (UserRepository $ur) {
            //             return $ur->createQueryBuilder('u')
            //                 ->orderBy('u.email', 'ASC');
            //         },
            //     'choice_label' => 'email',
                // 'choices' => [
                //     'OUI' => 'Oui',
                //     'NON' => 'Non',
                //     'JE NE SAIS PAS' => 'Je ne sais pas'
                //     ], 
                //     'choice_label' => function ($choice, $key, $value) {
                //       if ("Oui" === $choice) {
                //             return 'Tu sera le DG';
                //         }
                //         elseif('Non' === $choice)
                //         {
                //             return 'Tu ne sera pas le DG';
                //         }
                //         else{
                //             return "Tu ne sais pas";
                //         }
            
                //     return strtoupper($key);
                // },
                 // 'required' => false,
                // ])
            ->add('activitySector',  EntityType::class, [
                'class' => ActivitySector::class,
                'choice_label' => 'name',
                'mapped' => true,
                // 'required' => false,
            ])
            ->add('priority', EntityType::class, [
                'class' => Priority::class,
                'choice_label' => 'name',
                'mapped' => true,
                // 'required' => false,
                // 'choices' => $this->priorityRecup->findAll()
            ])
            ->add('companyType', EntityType::class, [
                'class' => CompaniesTypes::class,
                'choice_label' => 'name',
                'required' => false,
                'mapped' => true,
                // 'choices' => $this->companiesTypesRecup->findAll(),
                // 'multiple' => true 
                ]);
              
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
