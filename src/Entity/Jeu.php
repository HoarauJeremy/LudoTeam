<?php

namespace App\Entity;

use App\Repository\JeuRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: JeuRepository::class)]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap([
    "plateau" => Plateau::class,
    "carte" => Carte::class,
    "duel" => Duel::class
])]
class Jeu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(groups: ["evenement:list"])]
    private ?int $id = null;
    
    #[ORM\Column(length: 255)]
    #[Groups(groups: ["evenement:list"])]
    #[Assert\NotBlank]
    private ?string $nom = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(groups: ["evenement:list"])]
    #[Assert\NotNull]
    private ?int $nbParticipant = null;

    #[ORM\ManyToOne(inversedBy: 'jeux')]
    private ?Evenement $evenement = null;

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

    public function getNbParticipant(): ?int
    {
        return $this->nbParticipant;
    }

    public function setNbParticipant(int $nbParticipant): static
    {
        $this->nbParticipant = $nbParticipant;

        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement): static
    {
        $this->evenement = $evenement;

        return $this;
    }
}
