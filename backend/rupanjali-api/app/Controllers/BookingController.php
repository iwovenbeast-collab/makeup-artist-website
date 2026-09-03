<?php

namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\AvailabilityBlockModel;
use CodeIgniter\API\ResponseTrait;

class BookingController extends BaseController
{
    use ResponseTrait;

    /**
     * Fixed appointment windows.
     *
     * Morning   : 09:00 - 11:00
     * Afternoon : 12:00 - 14:00
     * Evening   : 15:00 - 18:00
     */
    private const APPOINTMENT_SLOTS = [
        '09:00:00' => '11:00:00',
        '12:00:00' => '14:00:00',
        '15:00:00' => '18:00:00',
    ];

    public function store()
    {
        $data = $this->request->getJSON(true);

        if (!$data) {
            return $this->failValidationErrors([
                'booking' => 'Invalid booking data.'
            ]);
        }

        /*
         * Required fields
         */
        $requiredFields = [
            'name',
            'phone',
            'event_type',
            'event_date',
            'start_time',
            'end_time',
            'location',
        ];

        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return $this->failValidationErrors([
                    $field => ucfirst(str_replace('_', ' ', $field))
                        . ' is required.'
                ]);
            }
        }

        /*
         * Basic validation
         */
        $rules = [
            'name'       => 'required|min_length[3]|max_length[100]',
            'phone'      => 'required|min_length[10]|max_length[20]',
            'email'      => 'permit_empty|valid_email|max_length[100]',
            'event_type' => 'required|max_length[50]',
            'event_date' => 'required',
            'start_time' => 'required',
            'end_time'   => 'required',
            'location'   => 'required|max_length[150]',
            'message'    => 'permit_empty',
        ];

        if (!$this->validateData($data, $rules)) {
            return $this->respond([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ], 422);
        }

        /*
         * Validate date.
         */
        $date = \DateTime::createFromFormat(
            'Y-m-d',
            $data['event_date']
        );

        if (
            !$date ||
            $date->format('Y-m-d') !== $data['event_date']
        ) {
            return $this->failValidationErrors([
                'event_date' => 'Invalid date. Use YYYY-MM-DD.'
            ]);
        }

        /*
         * Validate time format.
         */
        if (
            !$this->isValidTime($data['start_time']) ||
            !$this->isValidTime($data['end_time'])
        ) {
            return $this->failValidationErrors([
                'time' => 'Invalid time. Use HH:MM or HH:MM:SS.'
            ]);
        }

        $startTime = $this->normaliseTime($data['start_time']);
        $endTime   = $this->normaliseTime($data['end_time']);

        /*
         * ---------------------------------------------------------
         * CHECK 1: Requested time MUST be one of the fixed slots.
         * ---------------------------------------------------------
         */
        if (
            !isset(self::APPOINTMENT_SLOTS[$startTime]) ||
            self::APPOINTMENT_SLOTS[$startTime] !== $endTime
        ) {
            return $this->respond([
                'status' => false,
                'message' => 'Please select one of the available appointment windows.',
                'allowed_slots' => [
                    [
                        'start_time' => '09:00:00',
                        'end_time'   => '11:00:00',
                        'label'      => 'Morning',
                    ],
                    [
                        'start_time' => '12:00:00',
                        'end_time'   => '14:00:00',
                        'label'      => 'Afternoon',
                    ],
                    [
                        'start_time' => '15:00:00',
                        'end_time'   => '18:00:00',
                        'label'      => 'Evening',
                    ],
                ],
            ], 422);
        }

        /*
         * End time must be after start time.
         *
         * This is technically guaranteed by the fixed slots above,
         * but we keep the validation for safety.
         */
        if ($startTime >= $endTime) {
            return $this->failValidationErrors([
                'end_time' => 'End time must be after start time.'
            ]);
        }

        $bookingModel = new BookingModel();
        $blockModel   = new AvailabilityBlockModel();

        /*
         * ---------------------------------------------------------
         * CHECK 2: Entire day blocked
         * ---------------------------------------------------------
         */
        $allDayBlocked = $blockModel
            ->where('block_date', $data['event_date'])
            ->where('all_day', 1)
            ->first();

        if ($allDayBlocked) {
            return $this->respond([
                'status'  => false,
                'message' => 'This date is unavailable.',
                'reason'  => $allDayBlocked['reason'],
            ], 409);
        }

        /*
         * ---------------------------------------------------------
         * CHECK 3: Admin partial-day blocks
         * ---------------------------------------------------------
         */
        $blocks = $blockModel
            ->where('block_date', $data['event_date'])
            ->where('all_day', 0)
            ->findAll();

        foreach ($blocks as $block) {

            if (
                empty($block['start_time']) ||
                empty($block['end_time'])
            ) {
                continue;
            }

            $blockStart = $this->normaliseTime($block['start_time']);
            $blockEnd   = $this->normaliseTime($block['end_time']);

            if (
                $startTime < $blockEnd &&
                $endTime > $blockStart
            ) {
                return $this->respond([
                    'status'  => false,
                    'message' => 'This time is unavailable.',
                    'reason'  => $block['reason'],
                ], 409);
            }
        }

        /*
         * ---------------------------------------------------------
         * CHECK 4: Existing booking overlap
         * ---------------------------------------------------------
         */
        $existingBookings = $bookingModel
            ->where('event_date', $data['event_date'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('start_time IS NOT NULL', null, false)
            ->where('end_time IS NOT NULL', null, false)
            ->findAll();

        foreach ($existingBookings as $booking) {

            $existingStart = $this->normaliseTime(
                $booking['start_time']
            );

            $existingEnd = $this->normaliseTime(
                $booking['end_time']
            );

            if (
                $startTime < $existingEnd &&
                $endTime > $existingStart
            ) {
                return $this->respond([
                    'status'  => false,
                    'message' => 'This time has already been requested.',
                ], 409);
            }
        }

        /*
         * ---------------------------------------------------------
         * CREATE BOOKING
         * ---------------------------------------------------------
         */

        $data['start_time'] = $startTime;
        $data['end_time']   = $endTime;

        /*
         * Public bookings always start as pending.
         */
        $data['status'] = 'pending';

        /*
         * Public bookings come from the website.
         */
        $data['source'] = 'website';

        /*
         * Insert only fields supported by BookingModel.
         */
        $bookingModel->insert([
            'name'       => $data['name'],
            'phone'      => $data['phone'],
            'email'      => $data['email'] ?? null,
            'event_type' => $data['event_type'],
            'event_date' => $data['event_date'],
            'start_time' => $data['start_time'],
            'end_time'   => $data['end_time'],
            'location'   => $data['location'],
            'message'    => $data['message'] ?? null,
            'status'     => $data['status'],
            'source'     => $data['source'],
        ]);

        return $this->respondCreated([
            'status'  => 'success',
            'message' => 'Booking submitted successfully.',
        ]);
    }

    public function index()
    {
        $bookingModel = new BookingModel();

        return $this->respond(
            $bookingModel
                ->orderBy('created_at', 'DESC')
                ->findAll()
        );
    }

    private function isValidTime(string $time): bool
    {
        $formats = [
            'H:i',
            'H:i:s',
        ];

        foreach ($formats as $format) {

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