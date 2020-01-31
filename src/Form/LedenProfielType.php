<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LedenProfielType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   $builder


                    ->add('dateofbirth', BirthdayType::class)


                ;
            }

            public function configureOptions(OptionsResolver $resolver)
            {
                $resolver->setDefaults([
                    // Configure your form options here
                ]);
            }

}
