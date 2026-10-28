<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Order;
use App\Form\Type\OrderFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;

final class OrderController extends AbstractController
{
    #[Route('/orders', name: 'app_orders')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $orders = $entityManager->getRepository(Order::class)->findAll();

        return $this->render('order/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    #[Route('/order/{id}', name: 'app_order')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $order = $entityManager->getRepository(Order::class)->find($id);

        if (!$order) {
            throw $this->createNotFoundException(
                'No order found for id '.$id
            );
        }

        return $this->render('order/show.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/orders/create', name: 'order_create', methods: ['GET', 'POST'])]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $order = new Order();

        $form = $this->createForm(OrderFormType::class, $order);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($order);
            $entityManager->flush();

            return $this->redirectToRoute('app_orders');
        }

        return $this->render('order/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/order/edit/{id}', name: 'order_edit', methods: ['GET', 'POST'])]
    public function edit(Order $order, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(OrderFormType::class, $order);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($order);
            $entityManager->flush();

            return $this->redirectToRoute('app_orders');
        }

        return $this->render('order/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/order/delete/{id}', name: 'order_delete', methods: ['GET'])]
    public function delete(Order $order, ManagerRegistry $doctrine): RedirectResponse
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($order);
        $entityManager->flush();

        return $this->redirectToRoute('app_orders');
    }
}
