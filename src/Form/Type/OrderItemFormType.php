<?php

namespace App\Form\Type;

use App\Entity\Order;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OrderItemFormType extends AbstractType
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
            ->add('productName', TextType::class, ['empty_data' => ''])
            ->add('quantity', NumberType::class, ['empty_data' => ''])
            ->add('unitPrice', NumberType::class, ['empty_data' => ''])
            ->add('save', SubmitType::class, ['label' => 'Save'])
        ;
    }
}
