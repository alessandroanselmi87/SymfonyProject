<?php

namespace App\Form\Type;

use App\Entity\Client;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddressFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('client', EntityType::class, [
                'mapped' => true,
                'class' => Client::class,
                'choice_label' => function ($client) {
                    return $client->getId();
                },
                'choice_value' => 'id'
            ])
            ->add('street', TextType::class, ['empty_data' => ''])
            ->add('city', TextType::class, ['empty_data' => ''])
            ->add('postalCode', TextType::class, ['empty_data' => ''])
            ->add('country', TextType::class, ['empty_data' => ''])
            ->add('save', SubmitType::class, ['label' => 'Save'])
        ;
    }
}
