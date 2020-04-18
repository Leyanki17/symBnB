<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity (
 *      fields= {"email"},
 *      message= "Il existe deja un email '{{ value }}' dans le système essayer un autre mail"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min= 3,
     *      max= 100,
     *      minMessage= "Le prénom d'utilisateur doit avoir au moins 3 charactères.",
     *      maxMessage= "Le prénom d'utilisateur ne peux pas avoir plus de 100 charactères.",
     *      allowEmptyString= false
     * )
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min= 3,
     *      max= 100,
     *      minMessage= "Le nom d'utilisateur doit avoir au moins 3 charactères.",
     *      maxMessage= "Le nom d'utilisateur ne peux pas avoir plus de 100 charactères.",
     *      allowEmptyString= false
     * )
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *      message = "L'email '{{ value }}' n'est pas un email valide."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;
    /**
     * @Assert\EqualTo(
     *  propertyPath = "password",
     *  message= "Les mots passe ne correspondent pas veuiller rentrer deux mot de passe identique"
     * )
     */
   public $confirmPassword;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min= 20,
     *      max= 100,
     *      minMessage= "Votre introduction doit avoir au moins 20 charactères.",
     *      maxMessage= "Votre introduction ne peux pas avoir plus de 200 charactères.",
     *      allowEmptyString= false
     * )
     */
    private $introduction;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      min= 20,
     *      max= 1000,
     *      minMessage= "Votre description doit avoir au moins 20 charactères.",
     *      maxMessage= "Votre description ne peux pas avoir plus de 1000 charactères.",
     *      allowEmptyString= false
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar_url;

    /**
     * @ORM\Column(type="string", length=510)
     * * @Assert\Length(
     *      min= 7,
     *      max= 512,
     *      minMessage= "Le slug doit avoir au moins 7 charactères.",
     *      maxMessage= "Le slug ne peux pas avoir plus de 512 charactères.",
     *      allowEmptyString= false
     * )
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ad", mappedBy="user", orphanRemoval=true)
     */
    private $ads;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Role", mappedBy="users")
     */
    private $userRoles;

    public function __construct()
    {
        $this->ads = new ArrayCollection();
        $this->userRoles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): self
    {
        $this->introduction = $introduction;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }
    /**
     * Permet de generer un avatar 
     * @PrePersist
     * @PreUpdate
     * @return void
     */
    public function generateAvartar(){
        if(empty($this->avatar_url)){
            $this->avatar_url= 'https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png';
        }
    }

    public function setAvatarUrl(?string $avatar_url): self
    {
        $this->avatar_url = $avatar_url;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }
    
    /**
     * permet de modifier le slug avant l'enregistrement de l'netité
     * @PrePersist
     * @PreUpdate
     * @param string $slug
     * @return self
     */
     public function generateSlug(){
        if(empty($this->slug)){
            $slugify = new Slugify();
            $this->slug= $slugify->slugify($this->firstname.' '.$this->email.' '.$this->lastname);
        }
    }
     
    public function setSlug(?string $slug): self{
        $this->slug = $slug;

        return $this;   
    }
    /**
     * @return Collection|Ad[]
     */
    public function getAds(): Collection
    {
        return $this->ads;
    }

    public function addAd(Ad $ad): self
    {
        if (!$this->ads->contains($ad)) {
            $this->ads[] = $ad;
            $ad->setUser($this);
        }

        return $this;
    }

    public function removeAd(Ad $ad): self
    {
        if ($this->ads->contains($ad)) {
            $this->ads->removeElement($ad);
            // set the owning side to null (unless already changed)
            if ($ad->getUser() === $this) {
                $ad->setUser(null);
            }
        }

        return $this;
    }

    public function getRoles(){
        $roles=  $this->userRoles->map(function ($role){
            return $role->getName();
        })->toArray();
        $roles[]= 'ROLE_USER';
        return $roles;
    }


 
    public function getSalt(){

    }

    public function getUsername(){
        return $this->firstname.' '. $this->lastname;
    }

    public function eraseCredentials(){
        
    }

    /**
     * @return Collection|Role[]
     */
    public function getUserRoles(): Collection
    {
        return $this->userRoles;
    }

    public function addUserRole(Role $userRole): self
    {
        if (!$this->userRoles->contains($userRole)) {
            $this->userRoles[] = $userRole;
            $userRole->addUser($this);
        }

        return $this;
    }

    public function removeUserRole(Role $userRole): self
    {
        if ($this->userRoles->contains($userRole)) {
            $this->userRoles->removeElement($userRole);
            $userRole->removeUser($this);
        }

        return $this;
    }
}
