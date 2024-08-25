<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    private $bookingRepository;

    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    #[Route('/booking', methods: ['GET'])]
    public function index(): Response
    {
        $bookings = $this->bookingRepository->findAll();
        return $this->json($bookings);
    }

    #[Route('/booking', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $lessonId = $data['lesson_id'];
        $studentId = $data['student_id'];

        $lesson = $this->bookingRepository->findLesson($lessonId);
        if (!$lesson) {
            return new Response('Lesson not found', Response::HTTP_NOT_FOUND);
        }

        $lessonDate = new \DateTime($lesson['date']);
        $currentDate = new \DateTime();
        if ($currentDate->diff($lessonDate)->days > 30) {
            return new Response('Cannot book a lesson more than 30 days in advance', Response::HTTP_BAD_REQUEST);
        }

        if ($this->bookingRepository->checkExistingBooking($studentId, $lesson) > 0) {
            return new Response('Student already has a booking for this time slot', Response::HTTP_CONFLICT);
        }

        if (!$this->bookingRepository->checkLessonCapacity($lessonId)) {
            return new Response('No capacity available for this lesson', Response::HTTP_CONFLICT);
        }

        $this->bookingRepository->reduceLessonCapacity($lessonId);

        $newBooking = $this->bookingRepository->create($lessonId, $studentId);

        return $this->json($newBooking, Response::HTTP_CREATED);
    }

    #[Route('/booking/{id}', methods: ['GET'])]
    public function show($id): Response
    {
        $booking = $this->bookingRepository->find($id);

        if (!$booking) {
            return new Response('Booking not found', Response::HTTP_NOT_FOUND);
        }

        return $this->json($booking);
    }

    #[Route('/booking/{id}', methods: ['PUT'])]
    public function update(Request $request, $id): Response
    {
        $data = json_decode($request->getContent(), true);

        $updatedBooking = $this->bookingRepository->update($id, $data['lesson_id'], $data['student_id']);

        return $this->json($updatedBooking);
    }

    #[Route('/booking/{id}', methods: ['DELETE'])]
    public function delete($id): Response
    {
        $booking = $this->bookingRepository->find($id);
        if (!$booking) {
            return new Response('Booking not found', Response::HTTP_NOT_FOUND);
        }

        $lesson = $this->bookingRepository->findLesson($booking->getLessonId());
        if (!$lesson) {
            return new Response('Lesson not found', Response::HTTP_NOT_FOUND);
        }

        $lessonStartDateTime = new \DateTime($lesson['date'] . ' ' . $lesson['start_time']);
        if ((new \DateTime())->diff($lessonStartDateTime)->days <= 1) {
            return new Response('Cannot delete booking within 24 hours of the lesson', Response::HTTP_FORBIDDEN);
        }

        $this->bookingRepository->delete($id);
        $this->bookingRepository->restoreLessonCapacity($booking->getLessonId());

        return new Response('Booking deleted and capacity updated');
    }
}