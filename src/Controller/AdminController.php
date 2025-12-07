<?php

namespace App\Controller;

use App\Repository\MedecinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    #[Route('/dashboard', name: 'app_admin_dashboard')]
    public function dashboard(MedecinRepository $medecinRepository): Response
    {
        $totalMedecins = $medecinRepository->count([]);
        $totalMedecinType = $medecinRepository->countByType('medecin');
        $totalResident = $medecinRepository->countByType('resident');
        $totalEtudiant = $medecinRepository->countByType('etudiant');

        return $this->render('admin/dashboard.html.twig', [
            'totalMedecins' => $totalMedecins,
            'totalMedecinType' => $totalMedecinType,
            'totalResident' => $totalResident,
            'totalEtudiant' => $totalEtudiant,
        ]);
    }

    #[Route('/medecins', name: 'app_admin_medecins')]
    public function medecins(MedecinRepository $medecinRepository, Request $request): Response
    {
        $search = $request->query->get('search', '');
        $medecins = $medecinRepository->findByType('medecin', $search);
        $total = $medecinRepository->countByType('medecin');

        return $this->render('admin/medecins.html.twig', [
            'medecins' => $medecins,
            'total' => $total,
            'search' => $search,
            'type' => 'medecin',
            'typeLabel' => 'Médecins',
        ]);
    }

    #[Route('/residents', name: 'app_admin_residents')]
    public function residents(MedecinRepository $medecinRepository, Request $request): Response
    {
        $search = $request->query->get('search', '');
        $medecins = $medecinRepository->findByType('resident', $search);
        $total = $medecinRepository->countByType('resident');

        return $this->render('admin/medecins.html.twig', [
            'medecins' => $medecins,
            'total' => $total,
            'search' => $search,
            'type' => 'resident',
            'typeLabel' => 'Résidents / Internes',
        ]);
    }

    #[Route('/etudiants', name: 'app_admin_etudiants')]
    public function etudiants(MedecinRepository $medecinRepository, Request $request): Response
    {
        $search = $request->query->get('search', '');
        $medecins = $medecinRepository->findByType('etudiant', $search);
        $total = $medecinRepository->countByType('etudiant');

        return $this->render('admin/medecins.html.twig', [
            'medecins' => $medecins,
            'total' => $total,
            'search' => $search,
            'type' => 'etudiant',
            'typeLabel' => 'Étudiants',
        ]);
    }

    #[Route('/medecin/{id}', name: 'app_admin_medecin_show', requirements: ['id' => '\d+'])]
    public function showMedecin(int $id, MedecinRepository $medecinRepository): Response
    {
        $medecin = $medecinRepository->find($id);

        if (!$medecin) {
            throw $this->createNotFoundException('Médecin non trouvé');
        }

        return $this->render('admin/medecin_show.html.twig', [
            'medecin' => $medecin,
        ]);
    }

    #[Route('/receipt/{id}', name: 'app_admin_receipt', requirements: ['id' => '\d+'])]
    public function receipt(int $id, MedecinRepository $medecinRepository): Response
    {
        $medecin = $medecinRepository->find($id);

        if (!$medecin) {
            throw $this->createNotFoundException('Médecin non trouvé');
        }

        return $this->render('registration/receipt.html.twig', [
            'medecin' => $medecin,
        ]);
    }

    #[Route('/api/search', name: 'app_admin_api_search', methods: ['GET'])]
    public function apiSearch(MedecinRepository $medecinRepository, Request $request): Response
    {
        $search = $request->query->get('q', '');
        $type = $request->query->get('type', null);

        if (empty($search)) {
            return $this->json(['medecins' => []]);
        }

        $medecins = $medecinRepository->search($search, $type);

        $data = array_map(function($medecin) {
            return [
                'id' => $medecin->getId(),
                'nom' => $medecin->getNom(),
                'prenom' => $medecin->getPrenom(),
                'nomComplet' => $medecin->getNomComplet(),
                'email' => $medecin->getEmail(),
                'telephone' => $medecin->getTelephone(),
                'specialite' => $medecin->getSpecialite(),
                'lieuDeTravail' => $medecin->getLieuDeTravail(),
                'typeInscription' => $medecin->getTypeInscription(),
                'typeInscriptionLabel' => $medecin->getTypeInscriptionLabel(),
                'montant' => $medecin->getMontant(),
                'dateInscription' => $medecin->getDateInscription()->format('d/m/Y H:i'),
            ];
        }, $medecins);

        return $this->json(['medecins' => $data]);
    }
}

