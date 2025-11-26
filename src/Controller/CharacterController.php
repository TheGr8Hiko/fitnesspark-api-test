<?php

namespace App\Controller;

use App\Exception\ApiException;
use App\Service\CharacterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CharacterController extends AbstractController
{

    function __construct(
        private readonly CharacterService $characterService,
        private readonly ValidatorInterface $validator,
        )
    {

    }

    #[Route('/api/characters/{id}', name: 'api_characters_show', methods: ['GET'])]
    function show(int $id): JsonResponse
    {
        try {
            $characterDto = $this->characterService->getCharacterById($id);
        
            $errors = $this->validator->validate($characterDto);

            if(count($errors)>0){
                return $this->json([
                    'message'=>'Validation error',
                    'errors' => (string) $errors,
                ], 400);
            }

            return $this->json($characterDto, 200);
        } catch (ApiException $e) {

            $status = $e->getCode() > 0 ? $e->getCode() : 500;
        
            return $this->json([
                'message' => $e->getMessage(),
            ], $status);

        } catch (\Throwable $e) {

            return $this->json([
                'message' => 'Unexpected error',
            ], 500);
        }
        
    }

    #[Route('/api/characters', name: 'api_characters_show_all_characters', methods: ['GET'])]
    function index(Request $request): JsonResponse
    {
        $page = (int) $request->query->get('page', 1);
            if ($page < 1) {
                $page = 1;
            }
            
        try{
            $payload = $this->characterService->getCharacters($page);

            foreach($payload['results'] as $characterDto){
                $errors = $this->validator->validate($characterDto);
                
                if(count($errors)>0){
                    return $this->json([
                        'message'=>'Validation error',
                        'errors' => (string) $errors,
                    ], 400);
                }
            }

            return $this->json($payload, 200);
            
        } catch(ApiException $e){
            $status = $e->getCode() > 0 ? $e->getCode() : 500;
        
            return $this->json([
                'message' => $e->getMessage(),
            ], $status);
        } catch (\Throwable $e) {
            return $this->json([
                'message' => 'Unexpected error',
            ], 500);
        }
        
    }

}