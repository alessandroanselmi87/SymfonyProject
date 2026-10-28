<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ClientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, ['empty_data' => ''])
            ->add('lastname', TextType::class, ['empty_data' => ''])
            ->add('email', TextType::class, ['empty_data' => ''])
            ->add('phone', TextType::class, ['empty_data' => ''])
            ->add('createdAt', DateType::class, ['empty_data' => ''])
            ->add('save', SubmitType::class, ['label' => 'Save'])
        ;
    }
}