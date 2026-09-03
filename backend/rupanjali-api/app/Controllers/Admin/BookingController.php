<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingModel;

class BookingController extends BaseController
{
    private function checkAdmin()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        return null;
    }

    /**
     * Show create booking form
     */
    /**
     * Show create booking form
     */
    public function create()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $selectedDate = $this->request->getGet('date');

        /*
        * Only accept a valid YYYY-MM-DD date.
        * If the calendar did not provide a valid date,
        * leave it empty so the admin can choose one.
        */
        if ($selectedDate) {

            $date = \DateTime::createFromFormat(
                'Y-m-d',
                $selectedDate
            );

            if (
                !$date ||
                $date->format('Y-m-d') !== $selectedDate
            ) {
                $selectedDate = null;
            }
        }

        return view('admin/bookings/create', [
            'selectedDate' => $selectedDate,
        ]);
    }

    /**
     * Create booking manually from admin panel
     */
    public function store()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $data = $this->request->getPost();

        /*
        * Required fields
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
            'source'     => 'required|in_list[website,whatsapp,phone,other]',
            'status'     => 'required|in_list[pending,confirmed]',
        ];

        if (!$this->validateData($data, $rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    implode(
                        ' ',
                        $this->validator->getErrors()
                    )
                );
        }

        /*
        * Validate date
        */
        $date = \DateTime::createFromFormat(
            'Y-m-d',
            $data['event_date']
        );

        if (
            !$date ||
            $date->format('Y-m-d') !== $data['event_date']
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Invalid booking date.');
        }

        /*
        * Validate time
        */
        if (
            !$this->isValidTime($data['start_time']) ||
            !$this->isValidTime($data['end_time'])
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Invalid booking time.');
        }

        $startTime = $this->normaliseTime($data['start_time']);
        $endTime   = $this->normaliseTime($data['end_time']);

        if ($startTime >= $endTime) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'End time must be after start time.');
        }

                /*
        * Appointment windows
        *
        * Morning   : 09:00 - 11:00
        * Afternoon : 12:00 - 14:00
        * Evening   : 15:00 - 18:00
        */
        $allowedAppointmentSlots = [
            '09:00:00' => '11:00:00',
            '12:00:00' => '14:00:00',
            '15:00:00' => '18:00:00',
        ];

        if (
            !isset($allowedAppointmentSlots[$startTime]) ||
            $allowedAppointmentSlots[$startTime] !== $endTime
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Please select a valid appointment window: Morning (9:00 AM–11:00 AM), Afternoon (12:00 PM–2:00 PM), or Evening (3:00 PM–6:00 PM).'
                );
        }


        $bookingModel = new BookingModel();
        $blockModel   = new \App\Models\AvailabilityBlockModel();

        /*
        * ---------------------------------------------------------
        * CHECK 1 — Entire day unavailable
        * ---------------------------------------------------------
        */
        $allDayBlocked = $blockModel
            ->where('block_date', $data['event_date'])
            ->where('all_day', 1)
            ->first();

        if ($allDayBlocked) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'This date is unavailable.'
                );
        }

        /*
        * ---------------------------------------------------------
        * CHECK 2 — Partial unavailable period
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

            $blockStart = $this->normaliseTime(
                $block['start_time']
            );

            $blockEnd = $this->normaliseTime(
                $block['end_time']
            );

            if (
                $startTime < $blockEnd &&
                $endTime > $blockStart
            ) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        'This time is unavailable because of an existing availability block.'
                    );
            }
        }

        /*
        * ---------------------------------------------------------
        * CHECK 3 — Existing bookings
        * ---------------------------------------------------------
        *
        * Pending and confirmed bookings both reserve the time.
        */
        $existingBookings = $bookingModel
            ->where('event_date', $data['event_date'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('start_time IS NOT NULL', null, false)
            ->where('end_time IS NOT NULL', null, false)
            ->findAll();

        foreach ($existingBookings as $existing) {

            $existingStart = $this->normaliseTime(
                $existing['start_time']
            );

            $existingEnd = $this->normaliseTime(
                $existing['end_time']
            );

            if (
                $startTime < $existingEnd &&
                $endTime > $existingStart
            ) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        'This booking overlaps an existing pending or confirmed booking.'
                    );
            }
        }

        /*
        * ---------------------------------------------------------
        * CREATE BOOKING
        * ---------------------------------------------------------
        */
        $bookingModel->insert([
            'name'       => $data['name'],
            'phone'      => $data['phone'],
            'email'      => $data['email'] ?? null,
            'event_type' => $data['event_type'],
            'event_date' => $data['event_date'],
            'start_time' => $startTime,
            'end_time'   => $endTime,
            'location'   => $data['location'],
            'message'    => $data['message'] ?? null,
            'status'     => $data['status'],
            'source'     => $data['source'],
        ]);

        return redirect()
            ->to('/admin/bookings')
            ->with(
                'success',
                'Booking added successfully.'
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

    /**
     * Booking list
     */
    public function index()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        /*
        * ---------------------------------------------------------
        * FILTERS
        * ---------------------------------------------------------
        */

        $search   = trim($this->request->getGet('search') ?? '');
        $dateFrom = trim($this->request->getGet('date_from') ?? '');
        $dateTo   = trim($this->request->getGet('date_to') ?? '');
        $status   = trim($this->request->getGet('status') ?? '');

        /*
        * ---------------------------------------------------------
        * SUMMARY COUNTS
        *
        * These remain global, rather than changing with filters.
        * ---------------------------------------------------------
        */

        $pending = (new BookingModel())
            ->where('status', 'pending')
            ->countAllResults();

        $confirmed = (new BookingModel())
            ->where('status', 'confirmed')
            ->countAllResults();

        $cancelled = (new BookingModel())
            ->where('status', 'cancelled')
            ->countAllResults();

        /*
        * ---------------------------------------------------------
        * FILTERED + PAGINATED BOOKINGS
        * ---------------------------------------------------------
        */

        $model = new BookingModel();

        if ($search !== '') {
            $model->groupStart()
                ->like('name', $search)
                ->orLike('phone', $search)
                ->orLike('email', $search)
                ->groupEnd();
        }

        if ($dateFrom !== '') {
            $model->where('event_date >=', $dateFrom);
        }

        if ($dateTo !== '') {
            $model->where('event_date <=', $dateTo);
        }

        if (in_array($status, ['pending', 'confirmed', 'cancelled'], true)) {
            $model->where('status', $status);
        }

        $bookings = $model
            ->orderBy('event_date', 'ASC')
            ->orderBy('start_time', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->paginate(10, 'bookings');

        $pager = $model->pager;

        return view('admin/bookings/index', [
            'bookings'   => $bookings,
            'pager'      => $pager,
            'pending'    => $pending,
            'confirmed'  => $confirmed,
            'cancelled'  => $cancelled,
            'search'     => $search,
            'dateFrom'   => $dateFrom,
            'dateTo'     => $dateTo,
            'status'     => $status,
        ]);
    }

    /**
     * Confirm booking
     */
    public function confirm($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $model = new BookingModel();

        $booking = $model->find($id);

        if (!$booking) {
            return redirect()
                ->to('/admin/bookings')
                ->with('error', 'Booking not found.');
        }

        if ($booking['status'] === 'cancelled') {
            return redirect()
                ->to('/admin/bookings')
                ->with('error', 'A cancelled booking cannot be confirmed.');
        }

        /*
         * Check once again before confirming.
         *
         * This protects against another booking having been
         * confirmed since this request was originally submitted.
         */
        $existingBookings = $model
            ->where('id !=', $id)
            ->where('event_date', $booking['event_date'])
            ->where('status', 'confirmed')
            ->where('start_time IS NOT NULL', null, false)
            ->where('end_time IS NOT NULL', null, false)
            ->findAll();

        foreach ($existingBookings as $existing) {

            if (
                $booking['start_time'] < $existing['end_time'] &&
                $booking['end_time'] > $existing['start_time']
            ) {
                return redirect()
                    ->to('/admin/bookings')
                    ->with(
                        'error',
                        'Cannot confirm this booking because it overlaps another confirmed booking.'
                    );
            }
        }

        $model->update($id, [
            'status' => 'confirmed',
        ]);

        return redirect()
            ->to('/admin/bookings')
            ->with('success', 'Booking confirmed successfully.');
    }

    /**
     * Cancel booking
     */
    public function cancel($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $model = new BookingModel();

        $booking = $model->find($id);

        if (!$booking) {
            return redirect()
                ->to('/admin/bookings')
                ->with('error', 'Booking not found.');
        }

        $model->update($id, [
            'status' => 'cancelled',
        ]);

        return redirect()
            ->to('/admin/bookings')
            ->with('success', 'Booking cancelled.');
    }

    private function normaliseTime(string $time): string
    {
        if (strlen($time) === 5) {
            return $time . ':00';
        }

        return $time;
    }
}
