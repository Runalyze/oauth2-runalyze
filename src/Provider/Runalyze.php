<?php

namespace Runalyze\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Runalyze\OAuth2\Client\Exception\RunalyzeIdentityProviderException;
use Psr\Http\Message\ResponseInterface;

class Runalyze extends AbstractProvider
{

    /**
     * Returns the base URL for authorizing a client.
     */
    public function getBaseAuthorizationUrl(): string
    {
        return 'https://runalyze.com/oauth/v2/auth';
    }

    /**
     * Returns the base URL for requesting an access token.
     */
    public function getBaseAccessTokenUrl(array $params): string
    {
        return 'https://runalyze.com/oauth/v2/token';
    }

    /**
     * Returns the URL for requesting the resource owner's details.
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token): string
    {
        return 'https://runalyze.com/api/v1/athlete/extended';
    }

    /**
     * Returns the default scopes used by this provider.
     */
    protected function getDefaultScopes(): array
    {
        return [
            'athlete_extended'
        ];
    }

    /**
     * Checks a provider response for errors.
     *
     * @throws IdentityProviderException
     * @param  ResponseInterface $response
     * @param  array|string $data Parsed response data
     */
    protected function checkResponse(ResponseInterface $response, $data): void
    {
        if (!empty($data['error'])) {
            throw new RunalyzeIdentityProviderException(
                $data['error'] ?: $response->getReasonPhrase(),
                $response->getStatusCode(),
                $response
            );
        }
    }

    /**
     * Generates a resource owner object from a successful resource owner
     * details request.
     */
    protected function createResourceOwner(array $response, AccessToken $token): ResourceOwnerInterface
    {
        return new RunalyzeResourceOwner($response);
    }
}
