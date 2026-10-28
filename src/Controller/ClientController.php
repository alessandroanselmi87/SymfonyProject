<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Client;
use App\Form\Type\ClientFormType;
use Doctrine\Persistence\ManagerRegistry;

final class ClientController extends AbstractController
{

    #[Route('/clients', name: 'app_clients', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $clients = $entityManager->getRepository(Client::class)->findAll();

        return $this->render('client/index.html.twig', [
            'clients' => $clients,
        ]);
    }

    #[Route('/client/{id}', name: 'app_client')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {

        $client = $entityManager->getRepository(Client::class)->find($id);

        if (!$client) {
            throw $this->createNotFoundException(
                'No client found for id ' . $id
            );
        }

        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }

    #[Route('/clients/create', name: 'client_create', methods: ['GET', 'POST'])]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $client = new Client();

        $form = $this->createForm(ClientFormType::class, $client);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('app_clients');
        }

        return $this->render('client/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/clients/edit/{id}', name: 'client_edit', methods: ['GET', 'POST'])]
    public function edit(Client $client, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(ClientFormType::class, $client);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('app_clients');
        }

        return $this->render('client/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/client/delete/{id}', name: 'client_delete', methods: ['GET'])]
    public function delete(Client $client, ManagerRegistry $doctrine): RedirectResponse
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($client);
        $entityManager->flush();

        return $this->redirectToRoute('app_clients');
    }
}
