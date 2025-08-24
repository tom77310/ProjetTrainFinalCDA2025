<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 255)]
    private ?string $nomproduit;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?string $prix;

    #[ORM\Column(nullable: true)]
    private ?int $stock;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Categorie $categorie;

    /**
     * @var Collection<int, Tailles>
     */
    #[ORM\ManyToMany(targetEntity: Tailles::class, inversedBy: 'produits')]
    #[ORM\JoinTable(name: "produit_taille")]
    private Collection $tailles;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $vue1 = null;

    #[ORM\Column(length: 255)]
    private ?string $vue2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $vue3 = null;

    public function __construct()
    {
        $this->tailles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProduit(): ?string
    {
        return $this->nomproduit;
    }

    public function setNomProduit(string $nomproduit): static
    {
        $this->nomproduit = $nomproduit;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;
        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): static
    {
        $this->stock = $stock;
        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;
        return $this;
    }

    /**
     * @return Collection<int, Tailles>
     */
    public function getTailles(): Collection
    {
        return $this->tailles;
    }

    public function addTaille(Tailles $taille): static
    {
        if (!$this->tailles->contains($taille)) {
            $this->tailles->add($taille);
        }
        return $this;
    }

    public function removeTaille(Tailles $taille): static
    {
        $this->tailles->removeElement($taille);
        return $this;
    }

    public function getVue1(): ?string
    {
        return $this->vue1;
    }

    public function setVue1(?string $vue1): static
    {
        $this->vue1 = $vue1;

        return $this;
    }

    public function getVue2(): ?string
    {
        return $this->vue2;
    }

    public function setVue2(string $vue2): static
    {
        $this->vue2 = $vue2;

        return $this;
    }

    public function getVue3(): ?string
    {
        return $this->vue3;
    }

    public function setVue3(?string $vue3): static
    {
        $this->vue3 = $vue3;

        return $this;
    }
}
