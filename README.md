Fitness Park — Test Technique Symfony

Ce projet est une petite API REST développée avec Symfony.
Elle consomme une partie de l’API publique Rick & Morty, applique une architecture propre, et expose deux endpoints internes :

GET /api/characters/{id} → récupérer un personnage

GET /api/characters?page=X → récupérer une liste paginée de personnages

L’objectif est de montrer une structuration propre d’une API Symfony :
DTO, services, client HTTP, gestion d’erreurs, couches séparées, etc.




Stack Technique

    PHP 8.3

    Symfony 7

    Symfony HttpClient

    Symfony Validator

    Architecture DTO

    Gestion d’erreurs via exceptions




Architecture du Projet
src/
 ├── Controller/
 │    └── CharacterController.php
 ├── Service/
 │    ├── RickAndMortyClient.php     → Client HTTP (API externe)
 │    └── CharacterService.php       → Logique métier + mapping DTO
 ├── Dto/
 │    └── CharacterDto.php           → Modèle de données interne propre
 └── Exception/
      └── ApiException.php           → Exception métier personnalisée




Principes utilisés

DTO : structure interne typée

Service Layer : transformation, logique métier

Http Client : communication externe

Exception métier : gestion d’erreurs propre

Controller léger : seulement requêtes/réponses




Installation & Lancement
1. Installer les dépendances
composer install

2. Lancer le serveur Symfony
symfony serve


L’API sera disponible ici :

http://127.0.0.1:8000





Endpoints

1. Récupérer un personnage
GET /api/characters/{id}


Exemple

GET /api/characters/1


Réponse (200)

{
	"id": 1,
	"name": "Rick Sanchez",
	"status": "Alive",
	"species": "Human",
	"type": "",
	"gender": "Male",
	"origin": "Earth (C-137)",
	"location": "Citadel of Ricks",
	"image": "https://rickandmortyapi.com/api/character/avatar/1.jpeg"
}

Erreur

{
  "message": "Character 19999 not found"
}


Status : 404 Not Found




2. Récupérer la liste paginée des personnages
GET /api/characters?page=X


Exemple

GET /api/characters?page=2


Réponse (200)

{
  "page": 2,
  "totalPages": 42,
  "count": 826,
  "results": [
    { ...CharacterDto },
    { ...CharacterDto }
  ]
}


Erreur

{
  "message": "Page 199 not found"
}


Status : 404 Not Found




Gestion des erreurs

Toutes les erreurs liées à l’API externe ou à la logique métier sont encapsulées dans :

App\Exception\ApiException




Le controller capture cette exception et renvoie une réponse JSON propre avec le bon code HTTP.

Les erreurs internes non prévues renvoient :

{
  "message": "Unexpected error"
}


Status : 500




Temps passé

≈ 3 heures
(architecture, implémentation, tests, nettoyage)





Notes

L’objectif n’était pas de reproduire toute l’API Rick & Morty, mais de montrer une architecture Symfony propre et évolutive.

Le projet est facilement extensible (nouveaux endpoints, nouveaux DTOs, mise en cache, tests automatisés, etc.).

Aucun stockage local n’est nécessaire.