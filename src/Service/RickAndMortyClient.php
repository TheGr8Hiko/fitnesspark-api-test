<?php


namespace App\Service;

use App\Exception\ApiException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class RickAndMortyClient
{ 
    private const BASE_URL = 'https://rickandmortyapi.com/api';

    public function __construct(
        private readonly HttpClientInterface $httpClient
    ) {
    }

     /**
     * @throws ApiException
     */
    public function getCharacter(int $id): array
    {
        $url = self::BASE_URL . '/character/' . $id;

        try {
            $response = $this->httpClient->request('GET', $url);
            $statusCode = $response->getStatusCode();

            if ($statusCode === 404) {
                throw new ApiException(sprintf('Character %d not found', $id), 404);
            }

            if ($statusCode >= 400) {
                throw new ApiException('Error while calling external API', $statusCode);
            }

            return $response->toArray();
    
        } catch (ClientExceptionInterface|ServerExceptionInterface|TransportExceptionInterface $e){ 
            throw new ApiException(
                'External API call failed: ' . $e->getMessage(),
                502,
                $e
            );
        }
    }

    /**
     * @throws ApiException
     */
    public function getCharacters(int $page = 1): array
    {
        $url = self::BASE_URL . '/character?page=' . $page;

        try {
            $response = $this->httpClient->request('GET', $url);
            $statusCode = $response->getStatusCode();

            if ($statusCode === 404) {
                throw new ApiException(sprintf('page %d not found', $page), 404);
            }

            if ($statusCode >= 400) {
                throw new ApiException('Error while calling external API', $statusCode);
            }

            return $response->toArray();
    
        } catch (ClientExceptionInterface|ServerExceptionInterface|TransportExceptionInterface $e){ 
            throw new ApiException(
                'External API call failed: ' . $e->getMessage(),
                502,
                $e
            );
        }
    }

}