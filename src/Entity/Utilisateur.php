<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 180)]
    private ?string $email;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password;

    #[ORM\Column(length: 255)]
    private ?string $nom;

    #[ORM\Column(length: 255)]
    private ?string $prenom;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_naissance ;

    #[ORM\Column(length: 255)]
    private ?string $civilite;

    #[ORM\Column(length: 255)]
    private ?string $adresse;

    #[ORM\Column(length: 255)]
    private ?string $cp;

    #[ORM\Column(length: 255)]
    private ?string $ville;

    #[ORM\Column]
    private ?int $telephone;

    #[ORM\Column(length: 255)]
    private ?string $login;

    /**
     * @var Collection<int, Messages>
     */
    #[ORM\OneToMany(mappedBy: "expediteur", targetEntity: Messages::class, cascade: ["remove"], orphanRemoval: true)]
    private Collection $messages;

    /**
     * @var Collection<int, Messages>
     */
    #[ORM\OneToMany(targetEntity: Messages::class, mappedBy: 'message_utilisateur')]
    private Collection $message_utilisateur;

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'utilisateur', cascade: ['persist', 'remove'])]
    private Collection $commandes;

    #[ORM\OneToMany(targetEntity: Messages::class, mappedBy: 'expediteur')]
    private Collection $messagesEnvoyes;

    #[ORM\OneToMany(targetEntity: Messages::class, mappedBy: 'destinataire')]
    private Collection $messagesRecus;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->message_utilisateur = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->messagesEnvoyes = new ArrayCollection();
        $this->messagesRecus = new ArrayCollection();
    }

    public function getId(): ?int { 
        return $this->id; 
    }

    public function getEmail(): ?string { 
        return $this->email; 
    }
    public function setEmail(string $email): static { 
        $this->email = $email; return $this; 
    }

    public function getUserIdentifier(): string { 
        return (string) $this->email; 
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER'; // rôle par défaut
        return array_unique($roles);
    }

    public function setRoles(array $roles): static { 
        $this->roles = $roles; return $this; 
    }

    public function getPassword(): ?string { 
        return $this->password; 
    }
    public function setPassword(string $password): static { 
        $this->password = $password; 
        return $this; 
    }

    public function eraseCredentials(): void {}

    public function getNom(): ?string { 
        return $this->nom; 
    }
    public function setNom(string $nom): static { 
        $this->nom = $nom; 
        return $this; 
    }

    public function getPrenom(): ?string { 
        return $this->prenom; 
    }
    public function setPrenom(string $prenom): static { 
        $this->prenom = $prenom; 
        return $this; 
    }

    public function getDateNaissance(): ?\DateTimeInterface { 
        return $this->date_naissance; 
    }
    public function setDateNaissance(\DateTimeInterface $date_naissance): static { 
        $this->date_naissance = $date_naissance; 
        return $this; 
    }

    public function getCivilite(): ?string { 
        return $this->civilite; 
    }
    public function setCivilite(string $civilite): static { 
        $this->civilite = $civilite; 
        return $this; 
    }

    public function getAdresse(): ?string { 
        return $this->adresse; 
    }
    public function setAdresse(string $adresse): static {
        $this->adresse = $adresse; 
        return $this; 
    }

    public function getCp(): ?string { 
        return $this->cp; 
    }
    public function setCp(string $cp): static { 
        $this->cp = $cp; 
        return $this; 
    }

    public function getVille(): ?string { 
        return $this->ville; 
    }
    public function setVille(string $ville): static { 
        $this->ville = $ville; 
        return $this; 
    }

    public function getTelephone(): ?int { 
        return $this->telephone; 
    }
    public function setTelephone(int $telephone): static { 
        $this->telephone = $telephone; 
        return $this; 
    }

    public function getLogin(): ?string { 
        return $this->login; 
    }
    public function setLogin(string $login): static { 
        $this->login = $login; 
        return $this; 
    }

    /**
     * @return Collection<int, Messages>
     */
    public function getMessages(): Collection { return $this->messages; }

    public function addMessage(Messages $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setUtilisateur($this);
        }
        return $this;
    }

    public function removeMessage(Messages $message): static
    {
        if ($this->messages->removeElement($message)) {
            if ($message->getUtilisateur() === $this) {
                $message->setUtilisateur(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Messages>
     */
    public function getMessageUtilisateur(): Collection { 
        return $this->message_utilisateur; 
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection { 
        return $this->commandes; 
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setUtilisateur($this);
        }
        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            if ($commande->getUtilisateur() === $this) {
                $commande->setUtilisateur(null);
            }
        }
        return $this;
    }


        // Messages envoyés
    public function getMessagesEnvoyes(): Collection
    {
        return $this->messagesEnvoyes;
    }

    public function addMessagesEnvoye(Messages $message): static
    {
        if (!$this->messagesEnvoyes->contains($message)) {
            $this->messagesEnvoyes->add($message);
            $message->setExpediteur($this);
        }
        return $this;
    }

    public function removeMessagesEnvoye(Messages $message): static
    {
        if ($this->messagesEnvoyes->removeElement($message)) {
            if ($message->getExpediteur() === $this) {
                $message->setExpediteur(null);
            }
        }
        return $this;
    }

    // Messages reçus
    public function getMessagesRecus(): Collection
    {
        return $this->messagesRecus;
    }

    public function addMessagesRecu(Messages $message): static
    {
        if (!$this->messagesRecus->contains($message)) {
            $this->messagesRecus->add($message);
            $message->setDestinataire($this);
        }
        return $this;
    }

    public function removeMessagesRecu(Messages $message): static
    {
        if ($this->messagesRecus->removeElement($message)) {
            if ($message->getDestinataire() === $this) {
                $message->setDestinataire(null);
            }
        }
        return $this;
    }

}
