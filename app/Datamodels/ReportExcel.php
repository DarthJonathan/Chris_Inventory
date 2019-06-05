<?php
namespace App\Datamodels;

class ReportExcel
{
    public $date;
    public $invoice_id;
    public $tax_invoice_id;
    public $product_name;
    public $quantity;
    public $discount;
    public $price;
    public $tax_invoice_credited_date;
    public $tax_invoice_date;
    public $tax_invoice_no;
    public $total;
    public $tax_base;
    public $VAT;

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
    public function getTaxInvoiceCreditedDate()
    {
        return $this->tax_invoice_credited_date;
    }

    /**
     * @param mixed $tax_invoice_credited_date
     */
    public function setTaxInvoiceCreditedDate($tax_invoice_credited_date): void
    {
        $this->tax_invoice_credited_date = $tax_invoice_credited_date;
    }

    /**
     * @return mixed
     */
    public function getTaxInvoiceDate()
    {
        return $this->tax_invoice_date;
    }

    /**
     * @param mixed $tax_invoice_date
     */
    public function setTaxInvoiceDate($tax_invoice_date): void
    {
        $this->tax_invoice_date = $tax_invoice_date;
    }

    /**
     * @return mixed
     */
    public function getTaxInvoiceNo()
    {
        return $this->tax_invoice_no;
    }

    /**
     * @param mixed $tax_invoice_no
     */
    public function setTaxInvoiceNo($tax_invoice_no): void
    {
        $this->tax_invoice_no = $tax_invoice_no;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total): void
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getTaxBase()
    {
        return $this->tax_base;
    }

    /**
     * @param mixed $tax_base
     */
    public function setTaxBase($tax_base): void
    {
        $this->tax_base = $tax_base;
    }

    /**
     * @return mixed
     */
    public function getVAT()
    {
        return $this->VAT;
    }

    /**
     * @param mixed $VAT
     */
    public function setVAT($VAT): void
    {
        $this->VAT = $VAT;
    }
}