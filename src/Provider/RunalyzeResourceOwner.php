<?php

namespace Runalyze\OAuth2\Client\Provider;

use JetBrains\PhpStorm\Pure;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Tool\ArrayAccessorTrait;

class RunalyzeResourceOwner implements ResourceOwnerInterface
{
    use ArrayAccessorTrait;

    protected array $response;

    public function __construct(array $response = [])
    {
        $this->response = $response;
    }

    /**
     * Returns the identifier of the authorized resource owner.
     */
    public function getId(): mixed
    {
        return $this->getValueByKey($this->response, 'id');
    }

    /**
     * Returns email address of the resource owner
     */
    public function getEmail(): ?string
    {
        return $this->getValueByKey($this->response, 'mail');
    }

    /**
     * Returns full name of the resource owner
     */
    public function getName(): ?string
    {
        return $this->getValueByKey($this->response, 'username');
    }

    /**
     * Return all of the owner details available as an array.
     */
    public function toArray(): array
    {
        return $this->response;
    }
}
