<?php

namespace App\Controllers;

use App\Models\AvailabilityBlockModel;
use App\Models\BookingModel;
use CodeIgniter\API\ResponseTrait;

class AvailabilityController extends BaseController
{
    use ResponseTrait;

    /**
     * GET /api/availability
     *
     * Examples:
     *
     * /api/availability?date=2026-09-18
     *
     * /api/availability?start_date=2026-09-01&end_date=2026-09-30
     */
    public function index()
    {
        $date = $this->request->getGet('date');
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        if ($date) {
            if (!$this->isValidDate($date)) {
                return $this->failValidationErrors([
                    'date' => 'Invalid date. Use YYYY-MM-DD.'
                ]);
            }

            $startDate = $date;
            $endDate = $date;
        }

        if (!$startDate || !$endDate) {
            return $this->failValidationErrors([
                'date' => 'Provide date or start_date and end_date.'
            ]);
        }

        if (
            !$this->isValidDate($startDate) ||
            !$this->isValidDate($endDate)
        ) {
            return $this->failValidationErrors([
                'date' => 'Dates must use YYYY-MM-DD format.'
            ]);
        }

        if ($startDate > $endDate) {
            return $this->failValidationErrors([
                'date' => 'start_date cannot be after end_date.'
            ]);
        }

        $blockModel = new AvailabilityBlockModel();
        $bookingModel = new BookingModel();

        $blocks = $blockModel
            ->where('block_date >=', $startDate)
            ->where('block_date <=', $endDate)
            ->orderBy('block_date', 'ASC')
            ->orderBy('start_time', 'ASC')
            ->findAll();

        $bookings = $bookingModel
            ->where('event_date >=', $startDate)
            ->where('event_date <=', $endDate)
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('event_date', 'ASC')
            ->orderBy('start_time', 'ASC')
            ->findAll();

        $safeBookings = [];

        foreach ($bookings as $booking) {
            $safeBookings[] = [
                'id' => $booking['id'],
                'event_date' => $booking['event_date'],
                'start_time' => $booking['start_time'],
                'end_time' => $booking['end_time'],
                'event_type' => $booking['event_type'],
                'status' => $booking['status'],
            ];
        }

        $dates = [];

        $current = new \DateTime($startDate);
        $last = new \DateTime($endDate);

        while ($current <= $last) {

            $currentDate = $current->format('Y-m-d');

            $dateBlocks = array_values(
                array_filter(
                    $blocks,
                    fn ($block) =>
                        $block['block_date'] === $currentDate
                )
            );

            $dateBookings = array_values(
                array_filter(
                    $safeBookings,
                    fn ($booking) =>
                        $booking['event_date'] === $currentDate
                )
            );

            $allDayBlocked = false;

            foreach ($dateBlocks as $block) {
                if ((int) $block['all_day'] === 1) {
                    $allDayBlocked = true;
                    break;
                }
            }

            $dates[$currentDate] = [
                'all_day_blocked' => $allDayBlocked,
                'blocks' => $dateBlocks,
                'bookings' => $dateBookings,
            ];

            $current->modify('+1 day');
        }

        return $this->respond([
            'status' => true,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'dates' => $dates,
        ]);
    }


    /**
     * POST /api/availability
     *
     * Create an unavailable period.
     *
     * All day:
     *
     * {
     *   "block_date": "2026-09-18",
     *   "all_day": true,
     *   "reason": "Personal work"
     * }
     *
     * Partial day:
     *
     * {
     *   "block_date": "2026-09-18",
     *   "start_time": "14:00",
     *   "end_time": "17:00",
     *   "all_day": false,
     *   "reason": "Personal work"
     * }
     */
    public function store()
    {
        $data = $this->request->getJSON(true);

        if (!$data) {
            return $this->failValidationErrors([
                'availability' => 'Invalid request data.'
            ]);
        }

        if (empty($data['block_date'])) {
            return $this->failValidationErrors([
                'block_date' => 'Block date is required.'
            ]);
        }

        if (!$this->isValidDate($data['block_date'])) {
            return $this->failValidationErrors([
                'block_date' => 'Invalid date. Use YYYY-MM-DD.'
            ]);
        }

        $allDay = !empty($data['all_day']);

        /*
         * Whole-day block.
         */
        if ($allDay) {

            $data['start_time'] = null;
            $data['end_time'] = null;
            $data['all_day'] = 1;
        }

        /*
         * Partial-day block.
         */
        else {

            if (
                empty($data['start_time']) ||
                empty($data['end_time'])
            ) {
                return $this->failValidationErrors([
                    'time' => 'Start time and end time are required.'
                ]);
            }

            if (
                !$this->isValidTime($data['start_time']) ||
                !$this->isValidTime($data['end_time'])
            ) {
                return $this->failValidationErrors([
                    'time' => 'Invalid time. Use HH:MM or HH:MM:SS.'
                ]);
            }

            $data['start_time'] = $this->normaliseTime(
                $data['start_time']
            );

            $data['end_time'] = $this->normaliseTime(
                $data['end_time']
            );

            if ($data['start_time'] >= $data['end_time']) {
                return $this->failValidationErrors([
                    'end_time' => 'End time must be after start time.'
                ]);
            }

            $data['all_day'] = 0;
        }

        /*
         * Check if this block overlaps an existing booking.
         *
         * We don't allow the admin to accidentally mark a period
         * unavailable when a customer already has a pending or
         * confirmed booking during that period.
         */
        $bookingModel = new BookingModel();

        $bookings = $bookingModel
            ->where('event_date', $data['block_date'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->findAll();

        foreach ($bookings as $booking) {

            /*
             * Old bookings may not have times.
             * We cannot determine overlap for those.
             */
            if (
                empty($booking['start_time']) ||
                empty($booking['end_time'])
            ) {
                continue;
            }

            if ($allDay) {
                return $this->respond([
                    'status' => false,
                    'message' =>
                        'This date already contains a booking.'
                ], 409);
            }

            $bookingStart = $this->normaliseTime(
                $booking['start_time']
            );

            $bookingEnd = $this->normaliseTime(
                $booking['end_time']
            );

            if (
                $data['start_time'] < $bookingEnd &&
                $data['end_time'] > $bookingStart
            ) {
                return $this->respond([
                    'status' => false,
                    'message' =>
                        'This time overlaps an existing booking.'
                ], 409);
            }
        }

        $blockModel = new AvailabilityBlockModel();

        /*
         * Prevent duplicate all-day blocks.
         */
        if ($allDay) {

            $existing = $blockModel
                ->where('block_date', $data['block_date'])
                ->where('all_day', 1)
                ->first();

            if ($existing) {
                return $this->respond([
                    'status' => false,
                    'message' => 'This date is already blocked.'
                ], 409);
            }
        }

        /*
         * Prevent overlapping partial blocks.
         */
        else {

            $existingBlocks = $blockModel
                ->where('block_date', $data['block_date'])
                ->where('all_day', 0)
                ->findAll();

            foreach ($existingBlocks as $existing) {

                if (
                    empty($existing['start_time']) ||
                    empty($existing['end_time'])
                ) {
                    continue;
                }

                $existingStart = $this->normaliseTime(
                    $existing['start_time']
                );

                $existingEnd = $this->normaliseTime(
                    $existing['end_time']
                );

                if (
                    $data['start_time'] < $existingEnd &&
                    $data['end_time'] > $existingStart
                ) {
                    return $this->respond([
                        'status' => false,
                        'message' =>
                            'This time overlaps an existing unavailable period.'
                    ], 409);
                }
            }
        }

        $insertData = [
            'block_date' => $data['block_date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'all_day' => $data['all_day'],
            'reason' => $data['reason'] ?? null,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $id = $blockModel->insert($insertData);

        return $this->respondCreated([
            'status' => true,
            'message' => 'Availability block created.',
            'block' => $blockModel->find($id),
        ]);
    }


    /**
     * DELETE /api/availability/:id
     *
     * Remove an unavailable period.
     */
    public function delete($id)
    {
        $blockModel = new AvailabilityBlockModel();

        $block = $blockModel->find($id);

        if (!$block) {
            return $this->failNotFound(
                'Availability block not found.'
            );
        }

        $blockModel->delete($id);

        return $this->respond([
            'status' => true,
            'message' => 'Availability block removed.'
        ]);
    }


    private function isValidDate(string $date): bool
    {
        $parsed = \DateTime::createFromFormat(
            'Y-m-d',
            $date
        );

        return $parsed !== false
            && $parsed->format('Y-m-d') === $date;
    }


    private function isValidTime(string $time): bool
    {
        foreach (['H:i', 'H:i:s'] as $format) {

            $parsed = \DateTime::createFromFormat(
                $format,
                $time
            );

            if (
                $parsed !== false &&
                $parsed->format($format) === $time
            ) {
                return true;
            }
        }

        return false;
    }


    private function normaliseTime(string $time): string
    {
        if (strlen($time) === 5) {
            return $time . ':00';
        }

        return $time;
    }
}