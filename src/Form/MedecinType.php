<?php

namespace App\Form;

use App\Entity\Medecin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedecinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom *',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Votre nom',
                    'required' => true,
                ],
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom *',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Votre prénom',
                    'required' => true,
                ],
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Téléphone *',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex: +216 XX XXX XXX',
                    'required' => true,
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email *',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'votre.email@example.com',
                    'required' => true,
                ],
            ])
            ->add('specialite', ChoiceType::class, [
                'label' => 'Spécialité *',
                'choices' => [
                    'Anesthésie-Réanimation' => 'Anesthésie-Réanimation',
                    'Cardiologie' => 'Cardiologie',
                    'Chirurgie Générale' => 'Chirurgie Générale',
                    'Chirurgie Cardiaque' => 'Chirurgie Cardiaque',
                    'Chirurgie Orthopédique' => 'Chirurgie Orthopédique',
                    'Chirurgie Pédiatrique' => 'Chirurgie Pédiatrique',
                    'Chirurgie Plastique' => 'Chirurgie Plastique',
                    'Chirurgie Thoracique' => 'Chirurgie Thoracique',
                    'Chirurgie Vasculaire' => 'Chirurgie Vasculaire',
                    'Dermatologie' => 'Dermatologie',
                    'Endocrinologie' => 'Endocrinologie',
                    'Gastro-entérologie' => 'Gastro-entérologie',
                    'Gynécologie-Obstétrique' => 'Gynécologie-Obstétrique',
                    'Hématologie' => 'Hématologie',
                    'Infectiologie' => 'Infectiologie',
                    'Médecine de Famille' => 'Médecine de Famille',
                    'Médecine Dentaire' => 'Médecine Dentaire',
                    'Médecine Générale' => 'Médecine Générale',
                    'Médecine Interne' => 'Médecine Interne',
                    'Médecine d\'Urgence' => 'Médecine d\'Urgence',
                    'Néphrologie' => 'Néphrologie',
                    'Neurologie' => 'Neurologie',
                    'Neurochirurgie' => 'Neurochirurgie',
                    'Oncologie' => 'Oncologie',
                    'Ophtalmologie' => 'Ophtalmologie',
                    'ORL (Oto-Rhino-Laryngologie)' => 'ORL (Oto-Rhino-Laryngologie)',
                    'Pédiatrie' => 'Pédiatrie',
                    'Pneumologie' => 'Pneumologie',
                    'Psychiatrie' => 'Psychiatrie',
                    'Radiologie' => 'Radiologie',
                    'Rhumatologie' => 'Rhumatologie',
                    'Urologie' => 'Urologie',
                    'Autre' => 'Autre',
                ],
                'attr' => [
                    'class' => 'form-control',
                    'required' => true,
                ],
                'placeholder' => 'Sélectionnez votre spécialité',
            ])
            ->add('lieuDeTravail', TextType::class, [
                'label' => 'Région / Ville *',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex: Djerba, El May, Houmet Souk, Jerba',
                    'required' => true,
                ],
            ])
            ->add('typeInscription', ChoiceType::class, [
                'label' => 'Type d\'inscription *',
                'choices' => [
                    'Médecin (200 DT)' => 'medecin',
                    'Résident / Interne (100 DT)' => 'resident',
                    'Étudiant (50 DT)' => 'etudiant',
                ],
                'attr' => [
                    'class' => 'form-control',
                    'required' => true,
                ],
                'placeholder' => 'Sélectionnez votre type d\'inscription',
                'invalid_message' => 'Le type d\'inscription sélectionné n\'est pas valide.',
            ])
        ;

        // Calculer automatiquement le montant selon le type d'inscription
        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $medecin = $event->getData();
            if ($medecin && $medecin->getTypeInscription()) {
                $montant = $medecin->getMontantByType($medecin->getTypeInscription());
                $medecin->setMontant($montant);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Medecin::class,
        ]);
    }
}

