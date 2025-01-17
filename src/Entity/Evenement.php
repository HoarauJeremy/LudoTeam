<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
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

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(groups: ["evenement:list"])]
    #[Assert\Date]
    private ?\DateTimeImmutable $dateEvenement = null;

    /**
     * @var Collection<int, Jeu>
     */
    #[ORM\OneToMany(targetEntity: Jeu::class, mappedBy: 'evenement')]
    #[Groups(groups: ["evenement:list"])]
    private Collection $jeux;

    /**
     * @var Collection<int, Utilisateur>
     */
    #[ORM\ManyToMany(targetEntity: Utilisateur::class, inversedBy: 'evenements')]
    #[Groups(groups: ["evenement:list"])]
    private Collection $participant;

    #[ORM\ManyToOne(inversedBy: 'organiserPar')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(groups: ["evenement:list"])]
    private ?Utilisateur $organisateur = null;

    public function __construct()
    {
        $this->jeux = new ArrayCollection();
        $this->participant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEvenement(): ?\DateTimeImmutable
    {
        return $this->dateEvenement;
    }

    public function setDateEvenement(\DateTimeImmutable $dateEvenement): static
    {
        $this->dateEvenement = $dateEvenement;

        return $this;
    }

    /**
     * @return Collection<int, Jeu>
     */
    public function getJeux(): Collection
    {
        return $this->jeux;
    }

    public function addJeux(Jeu $jeux): static
    {
        if (!$this->jeux->contains($jeux)) {
            $this->jeux->add($jeux);
            $jeux->setEvenement($this);
        }

        return $this;
    }

    public function removeJeux(Jeu $jeux): static
    {
        if ($this->jeux->removeElement($jeux)) {
            // set the owning side to null (unless already changed)
            if ($jeux->getEvenement() === $this) {
                $jeux->setEvenement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getParticipant(): Collection
    {
        return $this->participant;
    }

    public function addParticipant(Utilisateur $participant): static
    {
        if (!$this->participant->contains($participant)) {
            $this->participant->add($participant);
        }

        return $this;
    }

    public function removeParticipant(Utilisateur $participant): static
    {
        $this->participant->removeElement($participant);

        return $this;
    }

    public function getOrganisateur(): ?Utilisateur
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?Utilisateur $organisateur): static
    {
        $this->organisateur = $organisateur;

        return $this;
    }
}
