<?php

namespace PrestaShop\Module\PrestashopCheckout\Temp\Entities;

class Shipping
{
    /** @var Address */
    private $address;

    /** @var string */
    private $name;

    /** @var string */
    private $type;

    public function __construct($address, $name, $type)
    {
        $this->address = $address;
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_filter([
            'address' => $this->getAddress()->toArray(),
            'name' => [
                'full_name' => $this->getName()
            ],
            'type' => $this->getType()
        ]);
    }
}
