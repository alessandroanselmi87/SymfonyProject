<?php

namespace App\Form\Type;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OrderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('client', EntityType::class, [
                'mapped' => true,
                'class' => Client::class,
                'choice_label' => function ($client) {
                    return $client->getFirstName() . " " . $client->getLastName();
                },
                'choice_value' => 'id'
            ])
            ->add('orderDate', DateTimeType::class, ['empty_data' => ''])
            ->add('status', TextType::class, ['empty_data' => ''])
            ->add('total', TextType::class, ['empty_data' => ''])
            ->add('save', SubmitType::class, ['label' => 'Save'])
        ;
    }
}
