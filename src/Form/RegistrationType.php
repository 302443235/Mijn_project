<?php


namespace App\Form;

use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('voornaam',TextType::class)
            ->add('achternaam',TextType::class)
            ->add('loginnaam',TextType::class)
            ->add('email',EmailType::class)
            ->add('password',TextType::class)
            ->add('preprovision',TextType::class)
            ->add('dateofbirth', BirthdayType::class)
            ->add('gender',ChoiceType::class,[
                'choices'=>["Man"=>'man' ,"Vrouw"=>'vrouw']
            ])

            ->add('street',TextType::class)
            ->add('postcode',TextType::class)
            ->add('place',TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}