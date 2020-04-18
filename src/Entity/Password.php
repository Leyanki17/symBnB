<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;


class Password
{
    /**
     * @Assert\Length(
     *      min=5,
     *      minMessage= "Le mot de passe doit posseder au moins 5 caractères"
     * )
     */
    private $lastPassword;
    
    /**
     * @Assert\Length(
     *      min=5,
     *      minMessage= "Le mot de passe doit posseder au moins 5 caractère"
     * )
     */
    private $newPassword;
    
    /**
     * @Assert\EqualTO(
     *      propertyPath= "newPassword",
     *      message= "Les mot de passe ne corresponde pas "
     * )
     */
    private $confirmNewPassword;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastPassword(): ?string
    {
        return $this->lastPassword;
    }

    public function setLastPassword(string $lastPassword): self
    {
        $this->lastPassword = $lastPassword;

        return $this;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    public function getConfirmNewPassword(): ?string
    {
        return $this->confirmNewPassword;
    }

    public function setConfirmNewPassword(string $confirmNewPassword): self
    {
        $this->confirmNewPassword = $confirmNewPassword;

        return $this;
    }
}
