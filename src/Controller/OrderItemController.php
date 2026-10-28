<?php

namespace App\Controller;

use App\Entity\OrderItem;
use App\Form\Type\OrderItemFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class OrderItemController extends AbstractController
{
    #[Route('/order_items', name: 'app_order_items')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $orderItems = $entityManager->getRepository(OrderItem::class)->findAll();

        return $this->render('order_item/index.html.twig', [
            'orderItems' => $orderItems,
        ]);
    }

    #[Route('/order_item/{id}', name: 'app_order_item')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {

        $orderItem = $entityManager->getRepository(OrderItem::class)->find($id);

        if (!$orderItem) {
            throw $this->createNotFoundException(
                'No order item found for id ' . $id
            );
        }

        return $this->render('order_item/show.html.twig', [
            'orderItem' => $orderItem,
        ]);
    }

    #[Route('/order_items/create', name: 'order_item_create', methods: ['GET', 'POST'])]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $orderItem = new OrderItem();

        $form = $this->createForm(OrderItemFormType::class, $orderItem);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orderItem = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($orderItem);
            $entityManager->flush();

            return $this->redirectToRoute('app_order_items');
        }

        return $this->render('order_item/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/order_items/edit/{id}', name: 'order_item_edit', methods: ['GET', 'POST'])]
    public function edit(OrderItem $orderItem, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(OrderItemFormType::class, $orderItem);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orderItem = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($orderItem);
            $entityManager->flush();

            return $this->redirectToRoute('app_order_items');
        }

        return $this->render('order_item/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/order_item/delete/{id}', name: 'order_item_delete', methods: ['GET'])]
    public function delete(OrderItem $orderItem, ManagerRegistry $doctrine): RedirectResponse
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($orderItem);
        $entityManager->flush();

        return $this->redirectToRoute('app_order_items');
    }
}
