<?php

namespace PrestaShop\Module\PrestashopCheckout\Temp\Entities;

class Amount
{
    /** @var Money */
    private $money;

    /** @var AmountBreakdown */
    private $breakdown;

    public function __construct($money, $breakdown = null)
    {
        $this->money = $money;
        $this->breakdown = $breakdown;
    }

    /**
     * @return Money
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * @return AmountBreakdown
     */
    public function getBreakdown()
    {
        return $this->breakdown;
    }

    public function toArray()
    {
        $data = [
            'money' => $this->getMoney()->toArray()
        ];

        if (!empty($this->getBreakdown())) {
            $data['breakdown'] = $this->getBreakdown()->toArray();
        }

        return $data;
    }
}
