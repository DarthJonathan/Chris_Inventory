<?php
namespace App\Datamodels;

class TaxInvoice
{
    /** @var Credited Date */
    public $credited_date;

    /** @var Date */
    public $date;

    /** @var id */
    public $id;

    /** @var tax $tax_invoice_no */
    public $tax_invoice_no;

    /**
     * @return mixed
     */
    public function getCreditedDate()
    {
        return $this->credited_date;
    }

    /**
     * @param mixed $credited_date
     */
    public function setCreditedDate($credited_date): void
    {
        $this->credited_date = $credited_date;
    }

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
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
}