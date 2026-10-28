<?php

namespace App\Form\Type;

use App\Entity\Order;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PaymentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('order', EntityType::class, [
                'mapped' => true,
                'class' => Order::class,
                'choice_label' => function ($order) {
                    return $order->getId();
                },
                'choice_value' => 'id'
            ])
            ->add('paymentDate', DateType::class, ['empty_data' => ''])
            ->add('paymentMethod', TextType::class, ['empty_data' => ''])
            ->add('amount', NumberType::class, ['empty_data' => ''])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'COMPLETED' => 'COMPLETED',
                    'PENDING' => 'PENDING',
                    'SUSPENDED' => 'SUSPENDED',
                    'READY' => 'READY'
                ]
            ])
            ->add('transactionId', TextType::class, ['empty_data' => ''])
            ->add('save', SubmitType::class, ['label' => 'Save'])
        ;
    }
}
