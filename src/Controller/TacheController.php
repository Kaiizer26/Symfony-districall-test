<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Form\TacheType;
use App\Repository\TacheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tache')]
final class TacheController extends AbstractController{
    #[Route(name: 'app_tache_index', methods: ['GET'])]
    public function index(Request $request, TacheRepository $tacheRepository): Response
    {
        $status = strtolower($request->query->get('status', ''));
        $search = $request->query->get('search', '');

        $queryBuilder = $tacheRepository->createQueryBuilder('t');
        $queryBuilder = $tacheRepository->createQueryBuilder('t');

        if ($status) {
            $queryBuilder->andWhere('t.status = :status') 
                         ->setParameter('status', $status);
        }
        

        if ($search) {
            $queryBuilder->andWhere('t.title LIKE :search OR t.description LIKE :search') 
                         ->setParameter('search', '%' . $search . '%');
        }
                $taches = $queryBuilder->getQuery()->getResult();
        
    
        // $taches = $queryBuilder->getQuery()->getResult();

        // $validStatuses = ['fait', 'en_cours', 'pas_fait']; 
        // $taches = in_array($status, $validStatuses) 
        // ? $tacheRepository->findBy(['status' => $status]) 
        // : $tacheRepository->findAll();
    
        return $this->render('tache/index.html.twig', [
            'taches' => $taches,
            'currentStatus' => $status,
            'currentSearch' => $search,
        ]);
    }

    #[Route('/new', name: 'app_tache_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tache = new Tache();
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tache);
            $entityManager->flush();

            return $this->redirectToRoute('app_tache_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tache/new.html.twig', [
            'tache' => $tache,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tache_show', methods: ['GET'])]
    public function show(Tache $tache): Response
    {
        return $this->render('tache/show.html.twig', [
            'tache' => $tache,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tache_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tache $tache, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_tache_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tache/edit.html.twig', [
            'tache' => $tache,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tache_delete', methods: ['POST'])]
    public function delete(Request $request, Tache $tache, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tache->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($tache);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_tache_index', [], Response::HTTP_SEE_OTHER);
    }
}
