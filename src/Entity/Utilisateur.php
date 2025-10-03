<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    // Email : format valide obligatoire
    #[ORM\Column(length: 180)]
    #[Assert\NotBlank(message: "L'email est obligatoire.")]
    #[Assert\Email(message: "L'email '{{ value }}' n'est pas valide.")]
    private ?string $email;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    // Mot de passe : au moins 12 caractères, 1 maj, 1 min, 1 chiffre
    #[ORM\Column]
    #[Assert\NotBlank(message: "Le mot de passe est obligatoire.")]
    #[Assert\Regex(
    pattern: "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{12,}$/",
    message: "Le mot de passe doit contenir au moins 12 caractères, dont une majuscule, une minuscule et un chiffre."
    )]
    private ?string $password;

    // Nom : uniquement lettres (accents autorisés), min 2 caractères
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    #[Assert\Regex(
    pattern: "/^[a-zA-ZÀ-ÿ\s-]{2,}$/u",
    message: "Le nom ne doit contenir que des lettres et au moins 2 caractères."
    )]
    private ?string $nom;

    // Prénom : idem que nom
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le prénom est obligatoire.")]
    #[Assert\Regex(
    pattern: "/^[a-zA-ZÀ-ÿ\s-]{2,}$/u",
    message: "Le prénom ne doit contenir que des lettres et au moins 2 caractères."
    )]
    private ?string $prenom;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_naissance ;

    #[ORM\Column(length: 255)]
    private ?string $civilite;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'adresse est obligatoire.")]
    #[Assert\Regex(
    pattern: "/^[a-zA-Z0-9À-ÿ\s,.\-\/]{5,}$/u",
    message: "L'adresse ne doit contenir que lettres, chiffres, espaces et les caractères , . - /, et au moins 5 caractères."
    )]
    private ?string $adresse;

    // Code postal : 5 chiffres
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le code postal est obligatoire.")]
    #[Assert\Regex(
        pattern: "/^[0-9]{5}$/",
        message: "Le code postal doit contenir exactement 5 chiffres."
    )]
    private ?string $cp;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La ville est obligatoire.")]
    #[Assert\Regex(
    pattern: "/^[a-zA-ZÀ-ÿ\s-]{2,}$/u",
    message: "La ville ne doit contenir que des lettres, espaces ou tirets et au moins 2 caractères."
    )]
    private ?string $ville;

    // Téléphone : 10 chiffres
     #[ORM\Column(type: "string", length: 10)]
    #[Assert\NotBlank(message: "Le numéro de téléphone est obligatoire.")]
    #[Assert\Regex(
        pattern: "/^\d{10}$/",
        message: "Le numéro de téléphone doit contenir exactement 10 chiffres."
    )]
    private ?string $telephone = null;

    // Login : lettres, chiffres, underscores, min 4 caractères
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le login est obligatoire.")]
    #[Assert\Regex(
    pattern: "/^[a-zA-Z0-9_]{4,}$/",
    message: "Le login doit contenir au moins 4 caractères et uniquement lettres, chiffres ou underscores."
    )]
    private ?string $login;



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

    #[ORM\OneToMany(mappedBy: "expediteur", targetEntity: Messages::class, cascade: ["remove"], orphanRemoval: true)]
    private Collection $messagesEnvoyes;

    #[ORM\OneToMany(targetEntity: Messages::class, mappedBy: 'destinataire')]
    private Collection $messagesRecus;

    public function __construct()
    {
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
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
