<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 255)]
    private string $code;

    #[ORM\Column]
    private float $taxPercent;

    public function __construct(string $code, float $taxPercent = 0.0)
    {
        $this->code       = $code;
        $this->taxPercent = $taxPercent;
        $this->id         = null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function getTaxPercent(): ?float
    {
        return $this->taxPercent;
    }

    public function setTaxPercent(float $taxPercent): self
    {
        $this->taxPercent = $taxPercent;

        return $this;
    }
}
