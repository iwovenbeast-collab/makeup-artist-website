<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AvailabilityBlockModel;
use App\Models\BookingModel;

class AvailabilityController extends BaseController
{
    public function index()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $blockModel = new AvailabilityBlockModel();
        $bookingModel = new BookingModel();

        $blocks = $blockModel
            ->orderBy('block_date', 'ASC')
            ->orderBy('start_time', 'ASC')
            ->findAll();

        $bookings = $bookingModel
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('event_date', 'ASC')
            ->orderBy('start_time', 'ASC')
            ->findAll();

        return view('admin/availability/index', [
            'blocks' => $blocks,
            'bookings' => $bookings,
        ]);
    }


    public function store()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $blockDate = $this->request->getPost('block_date');
        $startTime = $this->request->getPost('start_time');
        $endTime = $this->request->getPost('end_time');
        $allDay = $this->request->getPost('all_day') ? 1 : 0;
        $reason = trim($this->request->getPost('reason') ?? '');

        /*
         * Date validation
         */
        $date = \DateTime::createFromFormat('Y-m-d', $blockDate);

        if (
            !$date ||
            $date->format('Y-m-d') !== $blockDate
        ) {
            return redirect()
                ->back()
                ->with('error', 'Invalid date.');
        }

        /*
         * Full-day block
         */
        if ($allDay) {

            $startTime = null;
            $endTime = null;

        } else {

            /*
             * Partial-day block requires both times.
             */
            if (!$startTime || !$endTime) {
                return redirect()
                    ->back()
                    ->with('error', 'Start and end time are required.');
            }

            $startTime = $this->normaliseTime($startTime);
            $endTime = $this->normaliseTime($endTime);

            if ($startTime >= $endTime) {
                return redirect()
                    ->back()
                    ->with('error', 'End time must be after start time.');
            }
        }

        $blockModel = new AvailabilityBlockModel();

        /*
         * Prevent duplicate all-day blocks.
         */
        if ($allDay) {

            $existing = $blockModel
                ->where('block_date', $blockDate)
                ->where('all_day', 1)
                ->first();

            if ($existing) {
                return redirect()
                    ->back()
                    ->with('error', 'This date is already blocked.');
            }
        }

        /*
         * Prevent overlapping partial blocks.
         */
        if (!$allDay) {

            $existingBlocks = $blockModel
                ->where('block_date', $blockDate)
                ->where('all_day', 0)
                ->findAll();

            foreach ($existingBlocks as $existing) {

                if (
                    empty($existing['start_time']) ||
                    empty($existing['end_time'])
                ) {
                    continue;
                }

                if (
                    $startTime < $existing['end_time'] &&
                    $endTime > $existing['start_time']
                ) {
                    return redirect()
                        ->back()
                        ->with(
                            'error',
                            'This time overlaps an existing unavailable period.'
                        );
                }
            }
        }

        /*
         * Do not block a period that already contains a booking.
         */
        $bookingModel = new BookingModel();

        $bookings = $bookingModel
            ->where('event_date', $blockDate)
            ->whereIn('status', ['pending', 'confirmed'])
            ->findAll();

        foreach ($bookings as $booking) {

            if (
                empty($booking['start_time']) ||
                empty($booking['end_time'])
            ) {
                continue;
            }

            if ($allDay) {
                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'This date already contains a booking.'
                    );
            }

            $bookingStart = $this->normaliseTime(
                $booking['start_time']
            );

            $bookingEnd = $this->normaliseTime(
                $booking['end_time']
            );

            if (
                $startTime < $bookingEnd &&
                $endTime > $bookingStart
            ) {
                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'This time overlaps an existing booking.'
                    );
            }
        }

        $blockModel->insert([
            'block_date' => $blockDate,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'all_day' => $allDay,
            'reason' => $reason ?: null,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()
            ->to('/admin/availability')
            ->with('success', 'Availability block created.');
    }


    public function delete($id)
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $blockModel = new AvailabilityBlockModel();

        $block = $blockModel->find($id);

        if (!$block) {
            return redirect()
                ->back()
                ->with('error', 'Availability block not found.');
        }

        $blockModel->delete($id);

        return redirect()
            ->to('/admin/availability')
            ->with('success', 'Availability block removed.');
    }


    private function normaliseTime(string $time): string
    {
        if (strlen($time) === 5) {
            return $time . ':00';
        }

        return $time;
    }
}
