<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Repository\LessonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LessonController extends AbstractController
{
    private $lessonRepository;

    public function __construct()
    {
        $this->lessonRepository = new LessonRepository();
    }

    #[Route('/lesson', methods: ['GET'])]
    public function index(): Response
    {
        $lessons = $this->lessonRepository->findAll();

        $lessonObjects = array_map(function ($lesson) {
            return new Lesson(
                $lesson['id'],
                $lesson['classroom_id'],
                $lesson['start_time'],
                $lesson['end_time'],
                $lesson['date'],
                $lesson['capacity']
            );
        }, $lessons);

        return $this->json($lessonObjects);
    }

    #[Route('/lesson', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $capacity = $this->lessonRepository->findClassroomCapacity($data['classroom_id']);
        if ($capacity === null) {
            return new Response('Classroom not found', Response::HTTP_NOT_FOUND);
        }

        $data['capacity'] = $capacity;
        $lessonId = $this->lessonRepository->create($data);

        $newLesson = new Lesson(
            $lessonId,
            $data['classroom_id'],
            $data['start_time'],
            $data['end_time'],
            $data['date'],
            $data['capacity']
        );

        return $this->json($newLesson, Response::HTTP_CREATED);
    }

    #[Route('/lesson/{id}', methods: ['GET'])]
    public function show($id): Response
    {
        $lesson = $this->lessonRepository->find($id);

        if (!$lesson) {
            return new Response('Lesson not found', Response::HTTP_NOT_FOUND);
        }

        $lessonObject = new Lesson(
            $lesson['id'],
            $lesson['classroom_id'],
            $lesson['start_time'],
            $lesson['end_time'],
            $lesson['date'],
            $lesson['capacity']
        );

        return $this->json($lessonObject);
    }

    #[Route('/lesson/{id}', methods: ['PUT'])]
    public function update(Request $request, $id): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!$this->lessonRepository->update($id, $data)) {
            return new Response('Lesson not found', Response::HTTP_NOT_FOUND);
        }

        $updatedLesson = new Lesson(
            $id,
            $data['classroom_id'],
            $data['start_time'],
            $data['end_time'],
            $data['date'],
            $data['capacity']
        );

        return $this->json($updatedLesson);
    }

    #[Route('/lesson/{id}', methods: ['DELETE'])]
    public function delete($id): Response
    {
        if (!$this->lessonRepository->delete($id)) {
            return new Response('Lesson not found', Response::HTTP_NOT_FOUND);
        }

        return new Response('Lesson deleted');
    }
}