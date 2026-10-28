<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Form\Type\PaymentFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PaymentController extends AbstractController
{
    #[Route('/payments', name: 'app_payments')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $payments = $entityManager->getRepository(Payment::class)->findAll();

        return $this->render('payment/index.html.twig', [
            'payments' => $payments,
        ]);
    }

    #[Route('/payment/{id}', name: 'payment_show')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {

        $payment = $entityManager->getRepository(Payment::class)->find($id);

        if (!$payment) {
            throw $this->createNotFoundException(
                'No payment found for id ' . $id
            );
        }

        return $this->render('payment/show.html.twig', [
            'payment' => $payment,
        ]);
    }

    #[Route('/payments/create', name: 'payment_create', methods: ['GET', 'POST'])]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $payment = new Payment();

        $form = $this->createForm(PaymentFormType::class, $payment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $payment = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($payment);
            $entityManager->flush();

            return $this->redirectToRoute('app_payments');
        }

        return $this->render('payment/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/payments/edit/{id}', name: 'payment_edit', methods: ['GET', 'POST'])]
    public function edit(Payment $payment, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(PaymentFormType::class, $payment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $payment = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($payment);
            $entityManager->flush();

            return $this->redirectToRoute('app_payments');
        }

        return $this->render('payment/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/payments/delete/{id}', name: 'payment_delete', methods: ['GET'])]
    public function delete(Payment $payment, ManagerRegistry $doctrine): RedirectResponse
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($payment);
        $entityManager->flush();

        return $this->redirectToRoute('app_payments');
    }
}
