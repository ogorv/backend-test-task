<?php

namespace App\Entity;

use App\Enum\CouponTypeEnum;
use App\Repository\CouponRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 255)]
    private string $code;

    #[ORM\Column(enumType: CouponTypeEnum::class)]
    private CouponTypeEnum $type;

    #[ORM\Column]
    private float $discount;

    public function __construct(string $code, CouponTypeEnum $type, float $discount)
    {
        $this->code     = $code;
        $this->type     = $type;
        $this->discount = $discount;
        $this->id       = null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getType(): CouponTypeEnum
    {
        return $this->type;
    }

    public function setType(CouponTypeEnum $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDiscount(): float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }
}
