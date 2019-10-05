<?php
namespace App\Datamodels;

class Report
{
    public $date;
    public $invoice_id;
    public $tax_invoice_id;
    public $product_name;
    public $quantity;
    public $product_id;
    public $customer_id;
    public $discount;
    public $price;
    public $tax_invoice;
    public $customer;

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getInvoiceId()
    {
        return $this->invoice_id;
    }

    /**
     * @param mixed $invoice_id
     */
    public function setInvoiceId($invoice_id): void
    {
        $this->invoice_id = $invoice_id;
    }

    /**
     * @return mixed
     */
    public function getTaxInvoiceId()
    {
        return $this->tax_invoice_id;
    }

    /**
     * @param mixed $tax_invoice_id
     */
    public function setTaxInvoiceId($tax_invoice_id): void
    {
        $this->tax_invoice_id = $tax_invoice_id;
    }

    /**
     * @return mixed
     */
    public function getProductName()
    {
        return $this->product_name;
    }

    /**
     * @param mixed $product_name
     */
    public function setProductName($product_name): void
    {
        $this->product_name = $product_name;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param mixed $discount
     */
    public function setDiscount($discount): void
    {
        $this->discount = $discount;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getTaxInvoice()
    {
        return $this->tax_invoice;
    }

    /**
     * @param mixed $tax_invoice
     */
    public function setTaxInvoice($tax_invoice): void
    {
        $this->tax_invoice = $tax_invoice;
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     */
    public function setCustomer($customer): void
    {
        $this->customer = $customer;
    }
}

