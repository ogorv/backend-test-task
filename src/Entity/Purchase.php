<?php

namespace App\Entity;

use App\Enum\PurchaseStatusEnum;
use App\Repository\PurchaseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseRepository::class)]
class Purchase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'product_id', nullable: false)]
    private Product $product;

    #[ORM\Column(name: 'tax_number', length: 255)]
    private string $taxNumber;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'payment_provider_id', nullable: false)]
    private PaymentProvider $paymentProvider;

    #[ORM\Column(name: 'status', length: 255, enumType: PurchaseStatusEnum::class)]
    private PurchaseStatusEnum $status;

    #[ORM\Column(type: Types::FLOAT)]
    private float $price;

    public function __construct(
        Product            $product,
        string             $taxNumber,
        PaymentProvider    $paymentProvider,
        float              $price,
        PurchaseStatusEnum $status = PurchaseStatusEnum::NEW,
    ) {
        $this->product         = $product;
        $this->taxNumber       = $taxNumber;
        $this->paymentProvider = $paymentProvider;
        $this->status          = $status;
        $this->price           = $price;
        $this->id              = null;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    public function getPaymentProvider(): PaymentProvider
    {
        return $this->paymentProvider;
    }

    public function setStatus(PurchaseStatusEnum $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): PurchaseStatusEnum
    {
        return $this->status;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
