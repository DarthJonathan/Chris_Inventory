<?php


namespace App\Datamodels;


class InvoiceItem
{
    private $itemName;
    private $quantity;
    private $price;
    private $discount;

    /**
     * @return mixed
     */
    public function getItemName()
    {
        return $this->itemName;
    }

    /**
     * @param mixed $itemName
     */
    public function setItemName($itemName): void
    {
        $this->itemName = $itemName;
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
}
