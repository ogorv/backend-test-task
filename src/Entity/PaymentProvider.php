<?php

namespace App\Entity;

use App\Enum\PaymentProviderEnum;
use App\Repository\PaymentProviderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentProviderRepository::class)]
class PaymentProvider
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(enumType: PaymentProviderEnum::class)]
    private PaymentProviderEnum $alias;

    public function __construct(PaymentProviderEnum $alias)
    {
        $this->alias = $alias;
        $this->id    = null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlias(): PaymentProviderEnum
    {
        return $this->alias;
    }
}
