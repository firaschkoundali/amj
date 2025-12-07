<?php

namespace App\Entity;

use App\Repository\MedecinRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MedecinRepository::class)]
#[ORM\Table(name: 'medecins')]
class Medecin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Le nom est obligatoire')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Le nom doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Le nom ne peut pas dépasser {{ limit }} caractères'
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Le prénom est obligatoire')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Le prénom doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Le prénom ne peut pas dépasser {{ limit }} caractères'
    )]
    private ?string $prenom = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'Le téléphone est obligatoire')]
    #[Assert\Regex(
        pattern: '/^[0-9+\s\-()]+$/',
        message: 'Le numéro de téléphone n\'est pas valide'
    )]
    private ?string $telephone = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: 'L\'email est obligatoire')]
    #[Assert\Email(message: 'L\'email {{ value }} n\'est pas valide')]
    private ?string $email = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: 'La spécialité est obligatoire')]
    #[Assert\Length(
        min: 2,
        max: 150,
        minMessage: 'La spécialité doit contenir au moins {{ limit }} caractères',
        maxMessage: 'La spécialité ne peut pas dépasser {{ limit }} caractères'
    )]
    private ?string $specialite = null;

    #[ORM\Column(length: 200)]
    #[Assert\NotBlank(message: 'La région/ville est obligatoire')]
    #[Assert\Length(
        min: 2,
        max: 200,
        minMessage: 'La région/ville doit contenir au moins {{ limit }} caractères',
        maxMessage: 'La région/ville ne peut pas dépasser {{ limit }} caractères'
    )]
    private ?string $lieuDeTravail = null;

    #[ORM\Column(length: 50, nullable: false)]
    #[Assert\NotBlank(message: 'Le type d\'inscription est obligatoire')]
    #[Assert\Choice(choices: ['medecin', 'resident', 'etudiant'], message: 'Le type d\'inscription n\'est pas valide. Veuillez sélectionner parmi les options disponibles.')]
    private ?string $typeInscription = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $montant = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateInscription = null;

    public function __construct()
    {
        $this->dateInscription = new \DateTime();
    }

    public static function getTypesInscription(): array
    {
        return [
            'medecin' => 'Médecin',
            'resident' => 'Résident / Interne',
            'etudiant' => 'Étudiant',
        ];
    }

    public static function getMontants(): array
    {
        return [
            'medecin' => '200.00',
            'resident' => '100.00',
            'etudiant' => '50.00',
        ];
    }

    public function getMontantByType(string $type): string
    {
        return self::getMontants()[$type] ?? '0.00';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): static
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getLieuDeTravail(): ?string
    {
        return $this->lieuDeTravail;
    }

    public function setLieuDeTravail(string $lieuDeTravail): static
    {
        $this->lieuDeTravail = $lieuDeTravail;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): static
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getNomComplet(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    public function getTypeInscription(): ?string
    {
        return $this->typeInscription;
    }

    public function setTypeInscription(string $typeInscription): static
    {
        $this->typeInscription = $typeInscription;
        // Calculer automatiquement le montant selon le type
        $this->montant = $this->getMontantByType($typeInscription);
        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): static
    {
        $this->montant = $montant;
        return $this;
    }

    public function getTypeInscriptionLabel(): string
    {
        $types = self::getTypesInscription();
        return $types[$this->typeInscription] ?? $this->typeInscription;
    }
}

