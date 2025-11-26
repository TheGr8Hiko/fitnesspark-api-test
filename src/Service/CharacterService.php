<?php


namespace App\Service;

use App\Service\RickAndMortyClient;
use App\Dto\CharacterDto;
use App\Exception\ApiException;

class CharacterService {

    public function __construct(
        private readonly RickAndMortyClient $client
        )
    {
    }

    /**
     * @throws ApiException
     */
    public function getCharacterById(int $id): CharacterDto
    {
        $data = $this->client->getCharacter($id);

        return new CharacterDto(
            id: $data['id'],
            name: $data['name'],
            status: $data['status'],
            species: $data['species'],
            type: $data['type'] ?? null,
            gender: $data['gender'],
            origin: $data['origin']['name'] ?? null,
            location: $data['location']['name'] ?? null,
            image: $data['image'] ?? null,
        );

    }

    /**
     * @throws ApiException
     */
    public function getCharacters(int $page = 1): array
    {
        $data = $this->client->getCharacters($page);

        $characters = [];

        foreach($data['results'] as $characterData){
            $characters[] = new CharacterDto(
                id: $characterData['id'],
                name: $characterData['name'],
                status: $characterData['status'],
                species: $characterData['species'],
                type: $characterData['type'] ?? null,
                gender: $characterData['gender'],
                origin: $characterData['origin']['name'] ?? null,
                location: $characterData['location']['name'] ?? null,
                image: $characterData['image'] ?? null,
            );
        }
        return [
            'page'          => $page,
            'totalPages'    => $data['info']['pages'] ?? null,
            'count'         => $data['info']['count'] ?? null,
            'results'       => $characters,
        ];
    }


}