<?php

namespace App\Form\Auth;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Votre prénom *',
                'empty_data' => '',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Votre nom *',
                'empty_data' => '',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse mail *',
                'empty_data' => '',
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Votre mot de passe  *',
                    'help' => '8 caractère minimun, 1 majuscule, 1 minuscule, 1 chiffre',
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe',
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Accepter les termes d\'utilisation',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les termes d\'utilisation',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
