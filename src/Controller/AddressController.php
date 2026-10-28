<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\Type\AddressFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AddressController extends AbstractController
{
    #[Route('/addresses', name: 'app_addresses')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $addresses = $entityManager->getRepository(Address::class)->findAll();

        return $this->render('address/index.html.twig', [
            'addresses' => $addresses,
        ]);
    }

    #[Route('/address/{id}', name: 'address_show')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {

        $address = $entityManager->getRepository(Address::class)->find($id);

        if (!$address) {
            throw $this->createNotFoundException(
                'No address found for id ' . $id
            );
        }

        return $this->render('address/show.html.twig', [
            'address' => $address,
        ]);
    }

    #[Route('/addresses/create', name: 'address_create', methods: ['GET', 'POST'])]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $address = new Address();

        $form = $this->createForm(AddressFormType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($address);
            $entityManager->flush();

            return $this->redirectToRoute('app_addresses');
        }

        return $this->render('address/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/addresses/edit/{id}', name: 'address_edit', methods: ['GET', 'POST'])]
    public function edit(Address $address, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(AddressFormType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($address);
            $entityManager->flush();

            return $this->redirectToRoute('app_addresses');
        }

        return $this->render('address/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/addresses/delete/{id}', name: 'address_delete', methods: ['GET'])]
    public function delete(Address $address, ManagerRegistry $doctrine): RedirectResponse
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($address);
        $entityManager->flush();

        return $this->redirectToRoute('app_addresses');
    }
}
