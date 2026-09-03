<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\BlogModel;

class DashboardController extends BaseController
{
    public function index()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $bookingModel = new BookingModel();
        $blogModel    = new BlogModel();

        /*
         * ---------------------------------------------------------
         * DASHBOARD STATISTICS
         * ---------------------------------------------------------
         */

        $totalBookings = (new BookingModel())
            ->countAllResults();

        $pendingBookings = (new BookingModel())
            ->where('status', 'pending')
            ->countAllResults();

        $confirmedBookings = (new BookingModel())
            ->where('status', 'confirmed')
            ->countAllResults();

        $cancelledBookings = (new BookingModel())
            ->where('status', 'cancelled')
            ->countAllResults();

        $totalBlogs = $blogModel->countAllResults();

        /*
         * ---------------------------------------------------------
         * UPCOMING APPOINTMENTS
         * ---------------------------------------------------------
         *
         * Only pending + confirmed appointments are useful here.
         * Limit to 20 so the dashboard never becomes enormous.
         */

        $upcomingBookings = (new BookingModel())
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('event_date >=', date('Y-m-d'))
            ->orderBy('event_date', 'ASC')
            ->orderBy('start_time', 'ASC')
            ->limit(20)
            ->find();

        /*
         * ---------------------------------------------------------
         * RECENT BOOKINGS
         * ---------------------------------------------------------
         *
         * Latest 10 booking records.
         */

        $recentBookings = (new BookingModel())
            ->orderBy('created_at', 'DESC')
            ->limit(10)
            ->find();

        return view('admin/dashboard', [
            'totalBookings'     => $totalBookings,
            'pendingBookings'   => $pendingBookings,
            'confirmedBookings' => $confirmedBookings,
            'cancelledBookings' => $cancelledBookings,
            'totalBlogs'        => $totalBlogs,
            'upcomingBookings'  => $upcomingBookings,
            'recentBookings'    => $recentBookings,
        ]);
    }
}
