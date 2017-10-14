<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEdit extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, array(
                'label' => 'authentication.user.edit.form.1'
            ))
            ->add('lastName', TextType::class, array(
                'label' => 'authentication.user.edit.form.2'
            ))
            ->add('country', TextType::class, array(
                'label' => 'authentication.user.edit.form.3'
            ))
            ->add('city', TextType::class, array(
                'label' => 'authentication.user.edit.form.4'
            ))
            ->add('zip', IntegerType::class, array(
                'label' => 'authentication.user.edit.form.5'
            ))
            ->add('phone', IntegerType::class, array(
                'label' => 'authentication.user.edit.form.6'
            ))
            ->add('address', TextType::class, array(
                'label' => 'authentication.user.edit.form.7'
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
