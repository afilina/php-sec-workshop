<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RainbowRepository")
 */
class Rainbow
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $plaintext;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $hash;

    public function getId()
    {
        return $this->id;
    }

    public function getPlaintext(): ?string
    {
        return $this->plaintext;
    }

    public function setPlaintext(string $plaintext): self
    {
        $this->plaintext = $plaintext;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }
}
