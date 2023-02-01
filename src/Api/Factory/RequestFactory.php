<?php

namespace PrestaShop\Module\PrestashopCheckout\Api\Factory;

use GuzzleHttp\Psr7\Request;

class RequestFactory implements \Http\Message\RequestFactory
{
    // Pas très utile, peut être appeler directement Request ?
    public function createRequest($method, $uri, array $headers = [], $body = null, $protocolVersion = '1.1')
    {
        return new Request($method, $uri, $headers, $body, $protocolVersion);
    }
}
