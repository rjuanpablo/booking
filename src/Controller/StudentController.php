<?php

namespace App\Controller;

use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    private $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    #[Route('/student', methods: ['GET'])]
    public function index(): Response
    {
        $students = $this->studentRepository->findAll();
        return $this->json($students);
    }

    #[Route('/student', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $name = $data['name'];

        $newStudent = $this->studentRepository->create($name);

        return $this->json($newStudent, Response::HTTP_CREATED);
    }

    #[Route('/student/{id}', methods: ['GET'])]
    public function show($id): Response
    {
        $student = $this->studentRepository->find($id);

        if (!$student) {
            return new Response('Student not found', Response::HTTP_NOT_FOUND);
        }

        return $this->json($student);
    }

    #[Route('/student/{id}', methods: ['PUT'])]
    public function update(Request $request, $id): Response
    {
        $data = json_decode($request->getContent(), true);
        $name = $data['name'];

        $updatedStudent = $this->studentRepository->update($id, $name);

        return $this->json($updatedStudent);
    }

    #[Route('/student/{id}', methods: ['DELETE'])]
    public function delete($id): Response
    {
        $this->studentRepository->delete($id);
        return new Response('Student deleted');
    }
}