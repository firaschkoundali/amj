<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Form\MedecinType;
use App\Repository\MedecinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_registration')]
    public function register(
        Request $request,
        EntityManagerInterface $entityManager,
        MedecinRepository $medecinRepository
    ): Response {
        $medecin = new Medecin();
        $form = $this->createForm(MedecinType::class, $medecin);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if (!$form->isValid()) {
                // Afficher les erreurs de validation
                foreach ($form->getErrors(true) as $error) {
                    $this->addFlash('error', $error->getMessage());
                }
            } else {
                // Vérifier si l'email existe déjà
                $existingMedecin = $medecinRepository->findOneBy(['email' => $medecin->getEmail()]);
                
                if ($existingMedecin) {
                    $this->addFlash('warning', 'Cet email est déjà enregistré. Veuillez utiliser un autre email.');
                } else {
                    // S'assurer que le montant est défini
                    if ($medecin->getTypeInscription() && !$medecin->getMontant()) {
                        $medecin->setMontant($medecin->getMontantByType($medecin->getTypeInscription()));
                    }
                    
                    // S'assurer que la date d'inscription est définie
                    if (!$medecin->getDateInscription()) {
                        $medecin->setDateInscription(new \DateTime());
                    }
                    
                    try {
                        $entityManager->persist($medecin);
                        $entityManager->flush();

                        // Stocker l'ID pour la popup de confirmation
                        $this->addFlash('success_registration', $medecin->getId());

                        // Rediriger vers la page d'inscription pour afficher la popup
                        return $this->redirectToRoute('app_registration');
                    } catch (\Exception $e) {
                        $this->addFlash('error', 'Une erreur est survenue lors de l\'enregistrement : ' . $e->getMessage());
                    }
                }
            }
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/receipt/{id}', name: 'app_receipt', requirements: ['id' => '\d+'])]
    public function receipt(int $id, MedecinRepository $medecinRepository): Response
    {
        // Seul l'admin peut accéder au reçu
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $medecin = $medecinRepository->find($id);

        if (!$medecin) {
            throw $this->createNotFoundException('Médecin non trouvé');
        }

        return $this->render('registration/receipt.html.twig', [
            'medecin' => $medecin,
        ]);
    }
}

