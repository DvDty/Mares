<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('serialNumber', IntegerType::class, array(
                'required' => false
            ))
            ->add('description', TextareaType::class, array(
                'required' => false
            ))
            ->add('price', MoneyType::class, array(
                'required' => false
            ))
            ->add('secondary_category', null, array(
                'label' => 'Category'
            ))
            ->add('brand')
            ->add('live', null, array(
                'label' => 'Visible in the shop'
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Product'
        ));
    }
}
