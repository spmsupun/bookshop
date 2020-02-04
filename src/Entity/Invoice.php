<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvoiceRepository")
 */
class Invoice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $clientName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Coupon")
     */
    private $coupon;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $discount;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdDateTime;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InvoiceBooks", mappedBy="invoice")
     */
    private $invoiceBooks;

    public function __construct()
    {
        $this->invoiceBooks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    public function setClientName(string $clientName): self
    {
        $this->clientName = $clientName;

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

    public function getCoupon(): ?Coupon
    {
        return $this->coupon;
    }

    public function setCoupon(?Coupon $coupon): self
    {
        $this->coupon = $coupon;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(?float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getCreatedDateTime(): ?\DateTimeInterface
    {
        return $this->createdDateTime;
    }

    public function setCreatedDateTime(\DateTimeInterface $createdDateTime): self
    {
        $this->createdDateTime = $createdDateTime;

        return $this;
    }

    /**
     * @return Collection|InvoiceBooks[]
     */
    public function getInvoiceBooks(): Collection
    {
        return $this->invoiceBooks;
    }

    public function addInvoiceBook(InvoiceBooks $invoiceBook): self
    {
        if (!$this->invoiceBooks->contains($invoiceBook)) {
            $this->invoiceBooks[] = $invoiceBook;
            $invoiceBook->setInvoice($this);
        }

        return $this;
    }

    public function removeInvoiceBook(InvoiceBooks $invoiceBook): self
    {
        if ($this->invoiceBooks->contains($invoiceBook)) {
            $this->invoiceBooks->removeElement($invoiceBook);
            // set the owning side to null (unless already changed)
            if ($invoiceBook->getInvoice() === $this) {
                $invoiceBook->setInvoice(null);
            }
        }

        return $this;
    }
}
