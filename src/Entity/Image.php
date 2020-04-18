<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * Assert\Url(
     *      message="Veuiller entrer une Url valide"
     * )
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min= 10,
     *      max= 100,
     *      minMessage= "Vous devez entrer au moins 10 caractéres",
     *      maxMessage= "Vous devez enter moins de 100 caractéres",
     * )
     */
    private $caption;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ad", inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ad;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getCaption(): ?string
    {
        return $this->caption;
    }

    public function setCaption(string $caption): self
    {
        $this->caption = $caption;

        return $this;
    }

    public function getAd(): ?Ad
    {
        return $this->ad;
    }

    public function setAd(?Ad $ad): self
    {
        $this->ad = $ad;

        return $this;
    }
}
