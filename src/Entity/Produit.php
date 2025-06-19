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
    private ?int $id = null;

    #[ORM\Column]
    private ?int $prix = null;


    #[ORM\Column(length: 255)]
    private ?string $nom_produit = null;

    #[ORM\Column(length: 255)]
    private ?string $quantite = null;

   #[ORM\Column(type: 'text')]
    private ?string $detail = null;


    #[ORM\Column(length: 255)]
    private ?string $vue1 = null;

    #[ORM\Column(length: 255)]
    private ?string $vue2 = null;

    #[ORM\Column(length: 255)]
    private ?string $vue3 = null;

    /**
     * @var Collection<int, Utilisateur>
     */
    #[ORM\ManyToMany(targetEntity: Utilisateur::class, inversedBy: 'produits')]
    private Collection $utilisateur;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    /**
     * @var Collection<int, PageProduit>
     */
    #[ORM\OneToMany(targetEntity: PageProduit::class, mappedBy: 'produit')]
    private Collection $page_produit;

    #[ORM\ManyToOne(inversedBy: 'produit')]
    private ?Commande $commande = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PageProduit $pageproduit = null;

    public function __construct()
    {
        $this->utilisateur = new ArrayCollection();
        $this->page_produit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

        return $this;
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

    public function getQuantite(): ?string
    {
        return $this->quantite;
    }

    public function setQuantite(string $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(string $detail): static
    {
        $this->detail = $detail;

        return $this;
    }


    public function getVue1(): ?string
    {
        return $this->vue1;
    }

    public function setVue1(string $vue1): static
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

    public function setVue3(string $vue3): static
    {
        $this->vue3 = $vue3;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateur(): Collection
    {
        return $this->utilisateur;
    }

    public function addUtilisateur(Utilisateur $utilisateur): static
    {
        if (!$this->utilisateur->contains($utilisateur)) {
            $this->utilisateur->add($utilisateur);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): static
    {
        $this->utilisateur->removeElement($utilisateur);

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
     * @return Collection<int, PageProduit>
     */
    public function getPageProduit(): Collection
    {
        return $this->page_produit;
    }
    
    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): static
    {
        $this->commande = $commande;

        return $this;
    }

    public function setPageproduit(?PageProduit $pageproduit): static
    {
        $this->pageproduit = $pageproduit;

        return $this;
    }
}
