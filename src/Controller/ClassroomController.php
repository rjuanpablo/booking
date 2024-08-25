<?php

namespace App\Controller;

use App\Repository\ClassroomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    private $classroomRepository;

    public function __construct(ClassroomRepository $classroomRepository)
    {
        $this->classroomRepository = $classroomRepository;
    }

    #[Route('/classroom', methods: ['GET'])]
    public function index(): Response
    {
        $classrooms = $this->classroomRepository->findAll();
        return $this->json($classrooms);
    }

    #[Route('/classroom', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $newClassroom = $this->classroomRepository->create($data['name'], $data['capacity']);

        return $this->json($newClassroom, Response::HTTP_CREATED);
    }

    #[Route('/classroom/{id}', methods: ['GET'])]
    public function show($id): Response
    {
        $classroom = $this->classroomRepository->find($id);

        if (!$classroom) {
            return new Response('Classroom not found', Response::HTTP_NOT_FOUND);
        }

        return $this->json($classroom);
    }

    #[Route('/classroom/{id}', methods: ['PUT'])]
    public function update(Request $request, $id): Response
    {
        $data = json_decode($request->getContent(), true);

        $updatedClassroom = $this->classroomRepository->update($id, $data['name'], $data['capacity']);

        return $this->json($updatedClassroom);
    }

    #[Route('/classroom/{id}', methods: ['DELETE'])]
    public function delete($id): Response
    {
        $this->classroomRepository->delete($id);
        return new Response('Classroom deleted');
    }
}