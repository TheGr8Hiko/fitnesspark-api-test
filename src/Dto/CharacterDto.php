<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class CharacterDto
{
    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    public int $id;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public string $status;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public string $species;

    #[Assert\Type('string')]
    public ?string $type;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public string $gender;

    #[Assert\Type('string')]
    public ?string $origin;

    #[Assert\Type('string')]
    public ?string $location;

    #[Assert\Type('string')]
    public ?string $image;

    public function __construct(
        int $id,
        string $name,
        string $status,
        string $species,
        ?string $type,
        string $gender,
        ?string $origin,
        ?string $location,
        ?string $image
    ) {
        $this->id       = $id;
        $this->name     = $name;
        $this->status   = $status;
        $this->species  = $species;
        $this->type     = $type;
        $this->gender   = $gender;
        $this->origin   = $origin;
        $this->location = $location;
        $this->image    = $image;
    }
}