<?php

namespace App\Entity;

use App\Repository\LigneDeCommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneDeCommandeRepository::class)]
class LigneDeCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column]
    private ?int $quantiteCommande;

    #[ORM\Column]
    private ?int $prixUnitaireProduit;

    #[ORM\ManyToOne(inversedBy: 'ligneDeCommandes')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Commande $commande;

    #[ORM\ManyToOne(inversedBy: 'ligneDeCommandes')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Produit $produit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantiteCommande(): ?int
    {
        return $this->quantiteCommande;
    }

    public function setQuantiteCommande(int $quantiteCommande): static
    {
        $this->quantiteCommande = $quantiteCommande;
        return $this;
    }

    public function getPrixUnitaireProduit(): ?int
    {
        return $this->prixUnitaireProduit;
    }

    public function setPrixUnitaireProduit(int $prixUnitaireProduit): static
    {
        $this->prixUnitaireProduit = $prixUnitaireProduit;
        return $this;
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

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;
        return $this;
    }
}
