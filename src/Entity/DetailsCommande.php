<?php

namespace App\Entity;

use App\Repository\DetailsCommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailsCommandeRepository::class)]
class DetailsCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $prix_unitaire = null;

    #[ORM\Column(length: 255)]
    private ?string $quantite_commande = null;

    #[ORM\OneToOne(mappedBy: 'detailscommande', cascade: ['persist', 'remove'])]
    private ?Commande $commande = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixUnitaire(): ?int
    {
        return $this->prix_unitaire;
    }

    public function setPrixUnitaire(int $prix_unitaire): static
    {
        $this->prix_unitaire = $prix_unitaire;

        return $this;
    }

    public function getQuantiteCommande(): ?string
    {
        return $this->quantite_commande;
    }

    public function setQuantiteCommande(string $quantite_commande): static
    {
        $this->quantite_commande = $quantite_commande;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(Commande $commande): static
    {
        // set the owning side of the relation if necessary
        if ($commande->getDetailscommande() !== $this) {
            $commande->setDetailscommande($this);
        }

        $this->commande = $commande;

        return $this;
    }
}
