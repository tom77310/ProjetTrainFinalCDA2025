<?php

namespace App\Entity;

use App\Repository\PageProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PageProduitRepository::class)]
class PageProduit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_produit = null;

    #[ORM\Column(length: 255)]
    private ?string $taille_g = null;

    #[ORM\Column(length: 255)]
    private ?string $taille_n = null;

    #[ORM\Column(length: 255)]
    private ?string $taille_z = null;

    #[ORM\Column(length: 255)]
    private ?string $taille_ho = null;

    /**
     * @var Collection<int, Produit>
     */
    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'pageproduit')]
    private Collection $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProduit(): ?string
    {
        return $this->nom_produit;
    }

    public function setNomProduit(string $nom_produit): static
    {
        $this->nom_produit = $nom_produit;

        return $this;
    }

    public function getTailleG(): ?string
    {
        return $this->taille_g;
    }

    public function setTailleG(string $taille_g): static
    {
        $this->taille_g = $taille_g;

        return $this;
    }

    public function getTailleN(): ?string
    {
        return $this->taille_n;
    }

    public function setTailleN(string $taille_n): static
    {
        $this->taille_n = $taille_n;

        return $this;
    }

    public function getTailleZ(): ?string
    {
        return $this->taille_z;
    }

    public function setTailleZ(string $taille_z): static
    {
        $this->taille_z = $taille_z;

        return $this;
    }

    public function getTailleHo(): ?string
    {
        return $this->taille_ho;
    }

    public function setTailleHo(string $taille_ho): static
    {
        $this->taille_ho = $taille_ho;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): static
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->setPageproduit($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): static
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getPageproduit() === $this) {
                $produit->setPageproduit(null);
            }
        }

        return $this;
    }


}
