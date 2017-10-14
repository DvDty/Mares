<?php

namespace AppBundle\Form;

use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('password', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'invalid_message' => 'register.error.8',
                    'required' => true,
                    'first_options' => array('label' => 'authentication.register.form.1'),
                    'second_options' => array('label' => 'authentication.register.form.2'),
                )
            )
            ->add('firstName', TextType::class, array(
                'label' => 'authentication.register.form.3'
            ))
            ->add('lastName', TextType::class, array(
                'label' => 'authentication.register.form.4'
            ))
            ->add('recaptcha', EWZRecaptchaType::class, array(
                'label' => 'authentication.register.form.6'
            ))
            ->add('Register', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn-primary btn'),
                'label' => 'authentication.register.form.5'
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'translation_domain' => 'messages'
        ));
    }
}
