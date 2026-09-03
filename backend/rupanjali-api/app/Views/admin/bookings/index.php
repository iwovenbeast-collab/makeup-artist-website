<?= view('admin/layout/header', [
    'title' => 'Bookings | Rupanjali'
]) ?>

<?= view('admin/layout/sidebar') ?>

<div class="min-h-screen bg-[#faf7f4]">

    <div class="p-5 md:p-8 lg:p-10 max-w-[1600px] mx-auto">


        <!-- =====================================================
             HEADER
        ====================================================== -->

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5 mb-8">

            <div>

                <div class="flex items-center gap-3 mb-3">

                    <span class="w-10 h-px bg-[#c65d72]"></span>

                    <span class="text-[10px] uppercase tracking-[0.3em] text-[#c65d72]">
                        Client Requests
                    </span>

                </div>

                <h1 class="font-serif text-4xl md:text-5xl text-[#292322]">
                    Bookings
                </h1>

                <p class="text-[#817673] mt-3">
                    Manage appointment requests and confirmed dates.
                </p>

            </div>


            <a
                href="/admin/bookings/create"
                class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-[#292322] text-white text-sm font-medium hover:bg-[#3b3331] transition"
            >
                + Add Booking
            </a>

        </div>


        <!-- =====================================================
             FLASH MESSAGES
        ====================================================== -->

        <?php if (session()->getFlashdata('success')): ?>

            <div class="mb-6 rounded-2xl border border-green-100 bg-green-50 px-5 py-4 text-sm text-green-700">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>

        <?php endif; ?>


        <?php if (session()->getFlashdata('error')): ?>

            <div class="mb-6 rounded-2xl border border-red-100 bg-red-50 px-5 py-4 text-sm text-red-700">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>

        <?php endif; ?>


        <!-- =====================================================
             SUMMARY
        ====================================================== -->

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

            <div class="bg-white rounded-2xl border border-black/5 shadow-sm p-5">

                <p class="text-[10px] uppercase tracking-[0.2em] text-[#9b908b]">
                    Pending
                </p>

                <p class="font-serif text-3xl text-[#c65d72] mt-2">
                    <?= $pending ?>
                </p>

            </div>


            <div class="bg-white rounded-2xl border border-black/5 shadow-sm p-5">

                <p class="text-[10px] uppercase tracking-[0.2em] text-[#9b908b]">
                    Confirmed
                </p>

                <p class="font-serif text-3xl text-[#668a63] mt-2">
                    <?= $confirmed ?>
                </p>

            </div>


            <div class="bg-white rounded-2xl border border-black/5 shadow-sm p-5">

                <p class="text-[10px] uppercase tracking-[0.2em] text-[#9b908b]">
                    Cancelled
                </p>

                <p class="font-serif text-3xl text-[#8b8380] mt-2">
                    <?= $cancelled ?>
                </p>

            </div>

        </div>


        <!-- =====================================================
             FILTERS
        ====================================================== -->

        <form
            method="GET"
            action="/admin/bookings"
            class="bg-white rounded-3xl border border-black/5 shadow-sm p-5 md:p-6 mb-6"
        >

            <div class="flex items-center justify-between gap-4 mb-5">

                <div>

                    <p class="text-[10px] uppercase tracking-[0.2em] text-[#c65d72]">
                        Find bookings
                    </p>

                    <h2 class="font-serif text-2xl text-[#292322] mt-1">
                        Search & Filters
                    </h2>

                </div>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">


                <!-- Search -->

                <div class="xl:col-span-2">

                    <label class="block text-xs font-medium text-[#625b58] mb-2">
                        Search
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="<?= esc($search ?? '') ?>"
                        placeholder="Client name, phone or email"
                        class="w-full rounded-xl border border-black/10 bg-white px-4 py-3 outline-none transition focus:border-[#c65d72] focus:ring-2 focus:ring-[#c65d72]/10"
                    >

                </div>


                <!-- Status -->

                <div>

                    <label class="block text-xs font-medium text-[#625b58] mb-2">
                        Status
                    </label>

                    <select
                        name="status"
                        class="w-full rounded-xl border border-black/10 bg-white px-4 py-3 outline-none transition focus:border-[#c65d72] focus:ring-2 focus:ring-[#c65d72]/10"
                    >

                        <option value="">
                            All statuses
                        </option>

                        <option
                            value="pending"
                            <?= ($status ?? '') === 'pending' ? 'selected' : '' ?>
                        >
                            Pending
                        </option>

                        <option
                            value="confirmed"
                            <?= ($status ?? '') === 'confirmed' ? 'selected' : '' ?>
                        >
                            Confirmed
                        </option>

                        <option
                            value="cancelled"
                            <?= ($status ?? '') === 'cancelled' ? 'selected' : '' ?>
                        >
                            Cancelled
                        </option>

                    </select>

                </div>


                <!-- Date From -->

                <div>

                    <label class="block text-xs font-medium text-[#625b58] mb-2">
                        Date from
                    </label>

                    <input
                        type="date"
                        name="date_from"
                        value="<?= esc($dateFrom ?? '') ?>"
                        class="w-full rounded-xl border border-black/10 bg-white px-4 py-3 outline-none transition focus:border-[#c65d72] focus:ring-2 focus:ring-[#c65d72]/10"
                    >

                </div>


                <!-- Date To -->

                <div>

                    <label class="block text-xs font-medium text-[#625b58] mb-2">
                        Date to
                    </label>

                    <input
                        type="date"
                        name="date_to"
                        value="<?= esc($dateTo ?? '') ?>"
                        class="w-full rounded-xl border border-black/10 bg-white px-4 py-3 outline-none transition focus:border-[#c65d72] focus:ring-2 focus:ring-[#c65d72]/10"
                    >

                </div>

            </div>


            <div class="flex flex-col sm:flex-row gap-3 mt-5">

                <button
                    type="submit"
                    class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-[#292322] text-white text-sm font-medium hover:bg-[#3b3331] transition"
                >
                    Apply Filters
                </button>

                <a
                    href="/admin/bookings"
                    class="inline-flex items-center justify-center px-6 py-3 rounded-xl border border-black/10 bg-white text-[#5d5552] text-sm font-medium hover:bg-[#f7f2ef] transition"
                >
                    Clear Filters
                </a>

            </div>

        </form>


        <!-- =====================================================
             ACTIVE FILTER SUMMARY
        ====================================================== -->

        <?php

            $hasFilters =
                ($search ?? '') !== '' ||
                ($dateFrom ?? '') !== '' ||
                ($dateTo ?? '') !== '' ||
                ($status ?? '') !== '';

        ?>

        <?php if ($hasFilters): ?>

            <div class="flex flex-wrap items-center gap-2 mb-5">

                <span class="text-xs text-[#817673]">
                    Active filters:
                </span>


                <?php if (($search ?? '') !== ''): ?>

                    <span class="px-3 py-1.5 rounded-full bg-[#f4e8e8] text-[#9d5969] text-xs">
                        Search: <?= esc($search) ?>
                    </span>

                <?php endif; ?>


                <?php if (($dateFrom ?? '') !== ''): ?>

                    <span class="px-3 py-1.5 rounded-full bg-[#f3eee9] text-[#6d625d] text-xs">
                        From: <?= esc($dateFrom) ?>
                    </span>

                <?php endif; ?>


                <?php if (($dateTo ?? '') !== ''): ?>

                    <span class="px-3 py-1.5 rounded-full bg-[#f3eee9] text-[#6d625d] text-xs">
                        To: <?= esc($dateTo) ?>
                    </span>

                <?php endif; ?>


                <?php if (($status ?? '') !== ''): ?>

                    <span class="px-3 py-1.5 rounded-full bg-[#eef3eb] text-[#668a63] text-xs">
                        Status: <?= esc(ucfirst($status)) ?>
                    </span>

                <?php endif; ?>

            </div>

        <?php endif; ?>


        <!-- =====================================================
             BOOKING LIST
        ====================================================== -->

        <div class="bg-white rounded-3xl border border-black/5 shadow-sm overflow-hidden">


            <!-- List Header -->

            <div class="p-5 md:p-6 border-b border-black/5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">

                <div>

                    <p class="text-[10px] uppercase tracking-[0.2em] text-[#c65d72]">
                        Appointments
                    </p>

                    <h2 class="font-serif text-2xl text-[#292322] mt-1">
                        Booking Requests
                    </h2>

                </div>


                <?php if (isset($pager)): ?>

                    <p class="text-xs text-[#9b908b]">
                        <?= count($bookings) ?> shown on this page
                    </p>

                <?php endif; ?>

            </div>


            <?php if (empty($bookings)): ?>


                <!-- Empty -->

                <div class="p-12 text-center">

                    <div class="w-14 h-14 mx-auto rounded-full bg-[#f5efec] flex items-center justify-center text-[#9a8f8b] text-xl">
                        ✦
                    </div>

                    <h3 class="font-serif text-2xl text-[#292322] mt-4">
                        No bookings found
                    </h3>

                    <p class="text-sm text-[#817673] mt-2">
                        Try changing your search or filters.
                    </p>


                    <?php if ($hasFilters): ?>

                        <a
                            href="/admin/bookings"
                            class="inline-flex mt-5 px-5 py-2.5 rounded-xl bg-[#292322] text-white text-sm"
                        >
                            Clear filters
                        </a>

                    <?php endif; ?>

                </div>


            <?php else: ?>


                <!-- =================================================
                     DESKTOP
                ================================================== -->

                <div class="hidden md:block overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-[#faf6f3]">

                            <tr>

                                <th class="text-left px-5 py-4 text-[10px] uppercase tracking-[0.15em] text-[#9b908b]">
                                    Client
                                </th>

                                <th class="text-left px-5 py-4 text-[10px] uppercase tracking-[0.15em] text-[#9b908b]">
                                    Event
                                </th>

                                <th class="text-left px-5 py-4 text-[10px] uppercase tracking-[0.15em] text-[#9b908b]">
                                    Date & Time
                                </th>

                                <th class="text-left px-5 py-4 text-[10px] uppercase tracking-[0.15em] text-[#9b908b]">
                                    Location
                                </th>

                                <th class="text-left px-5 py-4 text-[10px] uppercase tracking-[0.15em] text-[#9b908b]">
                                    Status
                                </th>

                                <th class="text-left px-5 py-4 text-[10px] uppercase tracking-[0.15em] text-[#9b908b]">
                                    Action
                                </th>

                                <th class="w-12"></th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-black/5">


                            <?php foreach ($bookings as $booking): ?>

                                <?php

                                    $statusClass = match ($booking['status']) {

                                        'confirmed' =>
                                            'bg-[#eaf3e8] text-[#668a63]',

                                        'pending' =>
                                            'bg-[#fbf2df] text-[#a87531]',

                                        'cancelled' =>
                                            'bg-[#f0eeee] text-[#77706d]',

                                        default =>
                                            'bg-gray-100 text-gray-500',

                                    };

                                    $detailId =
                                        'booking-details-' .
                                        (int) $booking['id'];

                                ?>


                                <!-- Summary Row -->

                                <tr
                                    class="booking-summary-row group cursor-pointer hover:bg-[#fdfaf8] transition"
                                    data-booking-id="<?= (int) $booking['id'] ?>"
                                    data-detail-id="<?= esc($detailId) ?>"
                                >


                                    <!-- Client -->

                                    <td class="px-5 py-5 align-middle">

                                        <p class="font-medium text-[#292322] break-words">
                                            <?= esc($booking['name']) ?>
                                        </p>

                                        <p class="text-sm text-[#817673] mt-1">
                                            <?= esc($booking['phone']) ?>
                                        </p>

                                        <?php if (!empty($booking['email'])): ?>

                                            <p class="text-xs text-[#a09894] mt-1 break-all max-w-[220px]">
                                                <?= esc($booking['email']) ?>
                                            </p>

                                        <?php endif; ?>

                                    </td>


                                    <!-- Event -->

                                    <td class="px-5 py-5 align-middle">

                                        <p class="text-sm font-medium text-[#403936]">
                                            <?= esc($booking['event_type']) ?>
                                        </p>

                                        <?php if (!empty($booking['source'])): ?>

                                            <p class="text-[10px] uppercase tracking-wider text-[#a09894] mt-2">
                                                <?= esc($booking['source']) ?>
                                            </p>

                                        <?php endif; ?>

                                    </td>


                                    <!-- Date / Time -->

                                    <td class="px-5 py-5 align-middle whitespace-nowrap">

                                        <p class="text-sm font-medium text-[#292322]">

                                            <?= esc(
                                                date(
                                                    'd M Y',
                                                    strtotime(
                                                        $booking['event_date']
                                                    )
                                                )
                                            ) ?>

                                        </p>


                                        <?php if (
                                            !empty($booking['start_time']) &&
                                            !empty($booking['end_time'])
                                        ): ?>

                                            <p class="text-sm text-[#817673] mt-1">

                                                <?= esc(
                                                    date(
                                                        'g:i A',
                                                        strtotime(
                                                            $booking['start_time']
                                                        )
                                                    )
                                                ) ?>

                                                –

                                                <?= esc(
                                                    date(
                                                        'g:i A',
                                                        strtotime(
                                                            $booking['end_time']
                                                        )
                                                    )
                                                ) ?>

                                            </p>

                                        <?php else: ?>

                                            <p class="text-sm text-[#a09894] mt-1">
                                                Time not specified
                                            </p>

                                        <?php endif; ?>

                                    </td>


                                    <!-- Location -->

                                    <td class="px-5 py-5 align-middle max-w-[220px]">

                                        <p class="text-sm text-[#625b58] break-words">
                                            <?= esc($booking['location']) ?>
                                        </p>

                                    </td>


                                    <!-- Status -->

                                    <td class="px-5 py-5 align-middle">

                                        <span class="inline-flex px-3 py-1.5 rounded-full text-[10px] uppercase tracking-wider font-semibold <?= $statusClass ?>">
                                            <?= esc($booking['status']) ?>
                                        </span>

                                    </td>


                                    <!-- Actions -->

                                    <td class="px-5 py-5 align-middle">

                                        <?php if ($booking['status'] === 'pending'): ?>

                                            <div class="flex flex-wrap gap-2">

                                                <a
                                                    href="/admin/bookings/confirm/<?= (int) $booking['id'] ?>"
                                                    onclick="event.stopPropagation(); return confirm('Confirm this booking?')"
                                                    class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-[#292322] text-white text-xs font-medium hover:bg-[#3b3331] transition"
                                                >
                                                    Confirm
                                                </a>

                                                <a
                                                    href="/admin/bookings/cancel/<?= (int) $booking['id'] ?>"
                                                    onclick="event.stopPropagation(); return confirm('Cancel this booking?')"
                                                    class="inline-flex items-center justify-center px-4 py-2 rounded-xl border border-[#efc9c9] text-[#d85f5f] text-xs font-medium hover:bg-[#fff5f5] transition"
                                                >
                                                    Cancel
                                                </a>

                                            </div>

                                        <?php else: ?>

                                            <span class="text-xs text-[#b0a8a4]">
                                                —
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <!-- Expand -->

                                    <td class="px-4 py-5 align-middle">

                                        <span
                                            class="booking-chevron inline-flex w-9 h-9 rounded-full border border-black/5 bg-[#faf6f3] items-center justify-center text-[#6e6561] transition-transform duration-300"
                                        >
                                            ↓
                                        </span>

                                    </td>

                                </tr>


                                <!-- Expanded Details -->

                                <tr
                                    id="<?= esc($detailId) ?>"
                                    class="booking-details-row hidden"
                                >

                                    <td
                                        colspan="7"
                                        class="px-5 pb-5 bg-[#fdfaf8]"
                                    >

                                        <div class="rounded-2xl border border-black/5 bg-white overflow-hidden">


                                            <div class="grid grid-cols-1 lg:grid-cols-3 divide-y lg:divide-y-0 lg:divide-x divide-black/5">


                                                <!-- Client Details -->

                                                <div class="p-5 md:p-6">

                                                    <p class="text-[10px] uppercase tracking-[0.18em] text-[#c65d72] font-semibold mb-4">
                                                        Client Details
                                                    </p>


                                                    <div class="space-y-4">

                                                        <div>

                                                            <p class="text-[10px] uppercase tracking-wider text-[#a09894]">
                                                                Name
                                                            </p>

                                                            <p class="text-sm font-medium text-[#403936] mt-1 break-words">
                                                                <?= esc($booking['name']) ?>
                                                            </p>

                                                        </div>


                                                        <div>

                                                            <p class="text-[10px] uppercase tracking-wider text-[#a09894]">
                                                                Phone
                                                            </p>

                                                            <p class="text-sm font-medium text-[#403936] mt-1 break-all">
                                                                <?= esc($booking['phone']) ?>
                                                            </p>

                                                        </div>


                                                        <?php if (!empty($booking['email'])): ?>

                                                            <div>

                                                                <p class="text-[10px] uppercase tracking-wider text-[#a09894]">
                                                                    Email
                                                                </p>

                                                                <p class="text-sm font-medium text-[#403936] mt-1 break-all">
                                                                    <?= esc($booking['email']) ?>
                                                                </p>

                                                            </div>

                                                        <?php endif; ?>

                                                    </div>

                                                </div>


                                                <!-- Booking Details -->

                                                <div class="p-5 md:p-6">

                                                    <p class="text-[10px] uppercase tracking-[0.18em] text-[#c65d72] font-semibold mb-4">
                                                        Booking Details
                                                    </p>


                                                    <div class="space-y-4">

                                                        <div>

                                                            <p class="text-[10px] uppercase tracking-wider text-[#a09894]">
                                                                Event
                                                            </p>

                                                            <p class="text-sm font-medium text-[#403936] mt-1">
                                                                <?= esc($booking['event_type']) ?>
                                                            </p>

                                                        </div>


                                                        <div>

                                                            <p class="text-[10px] uppercase tracking-wider text-[#a09894]">
                                                                Date
                                                            </p>

                                                            <p class="text-sm font-medium text-[#403936] mt-1">

                                                                <?= esc(
                                                                    date(
                                                                        'd M Y',
                                                                        strtotime(
                                                                            $booking['event_date']
                                                                        )
                                                                    )
                                                                ) ?>

                                                            </p>

                                                        </div>


                                                        <div>

                                                            <p class="text-[10px] uppercase tracking-wider text-[#a09894]">
                                                                Time
                                                            </p>

                                                            <p class="text-sm font-medium text-[#403936] mt-1">

                                                                <?php if (
                                                                    !empty($booking['start_time']) &&
                                                                    !empty($booking['end_time'])
                                                                ): ?>

                                                                    <?= esc(
                                                                        date(
                                                                            'g:i A',
                                                                            strtotime(
                                                                                $booking['start_time']
                                                                            )
                                                                        )
                                                                    ) ?>

                                                                    –

                                                                    <?= esc(
                                                                        date(
                                                                            'g:i A',
                                                                            strtotime(
                                                                                $booking['end_time']
                                                                            )
                                                                        )
                                                                    ) ?>

                                                                <?php else: ?>

                                                                    Time not specified

                                                                <?php endif; ?>

                                                            </p>

                                                        </div>


                                                        <?php if (!empty($booking['source'])): ?>

                                                            <div>

                                                                <p class="text-[10px] uppercase tracking-wider text-[#a09894]">
                                                                    Source
                                                                </p>

                                                                <p class="text-sm font-medium text-[#403936] mt-1 capitalize">
                                                                    <?= esc($booking['source']) ?>
                                                                </p>

                                                            </div>

                                                        <?php endif; ?>

                                                    </div>

                                                </div>


                                                <!-- Location -->

                                                <div class="p-5 md:p-6">

                                                    <p class="text-[10px] uppercase tracking-[0.18em] text-[#c65d72] font-semibold mb-4">
                                                        Location
                                                    </p>


                                                    <p class="text-sm font-medium text-[#403936] leading-6 break-words">
                                                        <?= esc($booking['location']) ?>
                                                    </p>

                                                </div>

                                            </div>


                                            <!-- Message -->

                                            <?php if (!empty($booking['message'])): ?>

                                                <div class="border-t border-black/5 px-5 md:px-6 py-5">

                                                    <p class="text-[10px] uppercase tracking-[0.18em] text-[#c65d72] font-semibold mb-3">
                                                        Customer Message
                                                    </p>

                                                    <div class="rounded-xl bg-[#faf6f3] border border-black/[0.03] px-4 py-4">

                                                        <p class="text-sm leading-7 text-[#625b58] whitespace-pre-line break-words [overflow-wrap:anywhere]">
                                                            <?= esc(trim($booking['message'])) ?>
                                                        </p>

                                                    </div>

                                                </div>

                                            <?php endif; ?>

                                        </div>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>


                <!-- =================================================
                     MOBILE
                ================================================== -->

                <div class="md:hidden divide-y divide-black/5">

                    <?php foreach ($bookings as $booking): ?>

                        <?php

                            $statusClass = match ($booking['status']) {

                                'confirmed' =>
                                    'bg-[#eaf3e8] text-[#668a63]',

                                'pending' =>
                                    'bg-[#fbf2df] text-[#a87531]',

                                'cancelled' =>
                                    'bg-[#f0eeee] text-[#77706d]',

                                default =>
                                    'bg-gray-100 text-gray-500',

                            };

                            $mobileDetailId =
                                'mobile-booking-details-' .
                                (int) $booking['id'];

                        ?>


                        <!-- Mobile Summary -->

                        <article
                            class="mobile-booking-card p-5 cursor-pointer hover:bg-[#fdfaf8] transition"
                            data-mobile-detail-id="<?= esc($mobileDetailId) ?>"
                        >

                            <div class="flex items-start justify-between gap-4">

                                <div class="min-w-0 flex-1">

                                    <h3 class="font-medium text-[#292322] break-words">
                                        <?= esc($booking['name']) ?>
                                    </h3>

                                    <p class="text-sm text-[#817673] mt-1 break-all">
                                        <?= esc($booking['phone']) ?>
                                    </p>

                                </div>


                                <div class="flex flex-col items-end gap-2 shrink-0">

                                    <span class="inline-flex px-3 py-1.5 rounded-full text-[10px] uppercase tracking-wider font-semibold <?= $statusClass ?>">
                                        <?= esc($booking['status']) ?>
                                    </span>

                                    <span class="mobile-booking-chevron inline-flex w-8 h-8 rounded-full bg-[#faf6f3] items-center justify-center text-[#6e6561] transition-transform duration-300">
                                        ↓
                                    </span>

                                </div>

                            </div>


                            <div class="grid grid-cols-2 gap-x-5 gap-y-4 mt-5">

                                <div class="min-w-0">

                                    <p class="text-[10px] uppercase tracking-wider text-[#a09894]">
                                        Event
                                    </p>

                                    <p class="text-sm font-medium text-[#403936] mt-1 break-words">
                                        <?= esc($booking['event_type']) ?>
                                    </p>

                                </div>


                                <div class="min-w-0">

                                    <p class="text-[10px] uppercase tracking-wider text-[#a09894]">
                                        Date
                                    </p>

                                    <p class="text-sm font-medium text-[#403936] mt-1">
                                        <?= esc(
                                            date(
                                                'd M Y',
                                                strtotime(
                                                    $booking['event_date']
                                                )
                                            )
                                        ) ?>
                                    </p>

                                </div>


                                <div class="min-w-0">

                                    <p class="text-[10px] uppercase tracking-wider text-[#a09894]">
                                        Time
                                    </p>

                                    <p class="text-sm text-[#403936] mt-1">

                                        <?php if (
                                            !empty($booking['start_time']) &&
                                            !empty($booking['end_time'])
                                        ): ?>

                                            <?= esc(
                                                date(
                                                    'g:i A',
                                                    strtotime(
                                                        $booking['start_time']
                                                    )
                                                )
                                            ) ?>

                                            –

                                            <?= esc(
                                                date(
                                                    'g:i A',
                                                    strtotime(
                                                        $booking['end_time']
                                                    )
                                                )
                                            ) ?>

                                        <?php else: ?>

                                            Not specified

                                        <?php endif; ?>

                                    </p>

                                </div>


                                <div class="min-w-0">

                                    <p class="text-[10px] uppercase tracking-wider text-[#a09894]">
                                        Location
                                    </p>

                                    <p class="text-sm text-[#403936] mt-1 break-words">
                                        <?= esc($booking['location']) ?>
                                    </p>

                                </div>

                            </div>


                            <!-- Mobile Actions -->

                            <?php if ($booking['status'] === 'pending'): ?>

                                <div class="grid grid-cols-2 gap-3 mt-5">

                                    <a
                                        href="/admin/bookings/confirm/<?= (int) $booking['id'] ?>"
                                        onclick="event.stopPropagation(); return confirm('Confirm this booking?')"
                                        class="flex items-center justify-center rounded-xl bg-[#292322] text-white py-3 text-sm font-medium"
                                    >
                                        Confirm
                                    </a>

                                    <a
                                        href="/admin/bookings/cancel/<?= (int) $booking['id'] ?>"
                                        onclick="event.stopPropagation(); return confirm('Cancel this booking?')"
                                        class="flex items-center justify-center rounded-xl border border-[#efc9c9] text-[#d85f5f] py-3 text-sm font-medium"
                                    >
                                        Cancel
                                    </a>

                                </div>

                            <?php endif; ?>

                        </article>


                        <!-- Mobile Expanded Details -->

                        <div
                            id="<?= esc($mobileDetailId) ?>"
                            class="mobile-booking-details hidden bg-[#fdfaf8] px-5 pb-5"
                        >

                            <div class="rounded-2xl border border-black/5 bg-white overflow-hidden">


                                <div class="p-5">

                                    <p class="text-[10px] uppercase tracking-[0.18em] text-[#c65d72] font-semibold mb-4">
                                        Client Details
                                    </p>


                                    <div class="space-y-4">

                                        <div>

                                            <p class="text-[10px] uppercase tracking-wider text-[#a09894]">
                                                Name
                                            </p>

                                            <p class="text-sm font-medium text-[#403936] mt-1 break-words">
                                                <?= esc($booking['name']) ?>
                                            </p>

                                        </div>


                                        <div>

                                            <p class="text-[10px] uppercase tracking-wider text-[#a09894]">
                                                Phone
                                            </p>

                                            <p class="text-sm font-medium text-[#403936] mt-1 break-all">
                                                <?= esc($booking['phone']) ?>
                                            </p>

                                        </div>


                                        <?php if (!empty($booking['email'])): ?>

                                            <div>

                                                <p class="text-[10px] uppercase tracking-wider text-[#a09894]">
                                                    Email
                                                </p>

                                                <p class="text-sm font-medium text-[#403936] mt-1 break-all">
                                                    <?= esc($booking['email']) ?>
                                                </p>

                                            </div>

                                        <?php endif; ?>

                                    </div>

                                </div>


                                <div class="border-t border-black/5 p-5">

                                    <p class="text-[10px] uppercase tracking-[0.18em] text-[#c65d72] font-semibold mb-4">
                                        Booking Details
                                    </p>


                                    <div class="space-y-4">

                                        <div>

                                            <p class="text-[10px] uppercase tracking-wider text-[#a09894]">
                                                Event
                                            </p>

                                            <p class="text-sm font-medium text-[#403936] mt-1">
                                                <?= esc($booking['event_type']) ?>
                                            </p>

                                        </div>


                                        <div>

                                            <p class="text-[10px] uppercase tracking-wider text-[#a09894]">
                                                Date
                                            </p>

                                            <p class="text-sm font-medium text-[#403936] mt-1">
                                                <?= esc(
                                                    date(
                                                        'd M Y',
                                                        strtotime(
                                                            $booking['event_date']
                                                        )
                                                    )
                                                ) ?>
                                            </p>

                                        </div>


                                        <div>

                                            <p class="text-[10px] uppercase tracking-wider text-[#a09894]">
                                                Time
                                            </p>

                                            <p class="text-sm font-medium text-[#403936] mt-1">

                                                <?php if (
                                                    !empty($booking['start_time']) &&
                                                    !empty($booking['end_time'])
                                                ): ?>

                                                    <?= esc(
                                                        date(
                                                            'g:i A',
                                                            strtotime(
                                                                $booking['start_time']
                                                            )
                                                        )
                                                    ) ?>

                                                    –

                                                    <?= esc(
                                                        date(
                                                            'g:i A',
                                                            strtotime(
                                                                $booking['end_time']
                                                            )
                                                        )
                                                    ) ?>

                                                <?php else: ?>

                                                    Time not specified

                                                <?php endif; ?>

                                            </p>

                                        </div>


                                        <?php if (!empty($booking['source'])): ?>

                                            <div>

                                                <p class="text-[10px] uppercase tracking-wider text-[#a09894]">
                                                    Source
                                                </p>

                                                <p class="text-sm font-medium text-[#403936] mt-1 capitalize">
                                                    <?= esc($booking['source']) ?>
                                                </p>

                                            </div>

                                        <?php endif; ?>

                                    </div>

                                </div>


                                <div class="border-t border-black/5 p-5">

                                    <p class="text-[10px] uppercase tracking-[0.18em] text-[#c65d72] font-semibold mb-3">
                                        Location
                                    </p>

                                    <p class="text-sm font-medium text-[#403936] leading-6 break-words">
                                        <?= esc($booking['location']) ?>
                                    </p>

                                </div>


                                <?php if (!empty($booking['message'])): ?>

                                    <div class="border-t border-black/5 p-5">

                                        <p class="text-[10px] uppercase tracking-[0.18em] text-[#c65d72] font-semibold mb-3">
                                            Customer Message
                                        </p>

                                        <div class="rounded-xl bg-[#faf6f3] px-4 py-4">

                                            <p class="text-sm leading-7 text-[#625b58] whitespace-pre-line break-words [overflow-wrap:anywhere]">
                                                <?= esc(trim($booking['message'])) ?>
                                            </p>

                                        </div>

                                    </div>

                                <?php endif; ?>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>


                <!-- =================================================
                     PAGINATION
                ================================================== -->

                <?php if (
                    isset($pager) &&
                    $pager->getPageCount('bookings') > 1
                ): ?>

                    <?php

                        $currentPage =
                            $pager->getCurrentPage('bookings');

                        $pageCount =
                            $pager->getPageCount('bookings');

                        $query = [
                            'search' =>
                                $search ?? '',

                            'date_from' =>
                                $dateFrom ?? '',

                            'date_to' =>
                                $dateTo ?? '',

                            'status' =>
                                $status ?? '',
                        ];

                        $queryString =
                            http_build_query(
                                array_filter(
                                    $query,
                                    fn($value) =>
                                        $value !== ''
                                )
                            );

                        $pageUrl =
                            function ($page)
                            use ($queryString) {

                                return
                                    '/admin/bookings?page_bookings=' .
                                    $page .
                                    (
                                        $queryString
                                            ? '&' . $queryString
                                            : ''
                                    );

                            };

                    ?>


                    <div class="border-t border-black/5 bg-[#faf6f3] px-5 md:px-6 py-5">

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">


                            <p class="text-xs text-[#817673]">

                                Page

                                <span class="font-medium text-[#4d4542]">
                                    <?= $currentPage ?>
                                </span>

                                of

                                <span class="font-medium text-[#4d4542]">
                                    <?= $pageCount ?>
                                </span>

                            </p>


                            <div class="flex items-center gap-1.5">


                                <?php if ($currentPage > 1): ?>

                                    <a
                                        href="<?= esc($pageUrl($currentPage - 1)) ?>"
                                        class="px-3.5 py-2 rounded-xl border border-black/10 bg-white text-sm text-[#5d5552] hover:bg-[#f3eeeb] transition"
                                    >
                                        ← Previous
                                    </a>

                                <?php else: ?>

                                    <span class="px-3.5 py-2 rounded-xl border border-black/5 bg-[#f3eeeb] text-sm text-[#b4aca8]">
                                        ← Previous
                                    </span>

                                <?php endif; ?>


                                <?php

                                    $startPage =
                                        max(
                                            1,
                                            $currentPage - 2
                                        );

                                    $endPage =
                                        min(
                                            $pageCount,
                                            $currentPage + 2
                                        );

                                ?>


                                <?php for (
                                    $page = $startPage;
                                    $page <= $endPage;
                                    $page++
                                ): ?>

                                    <?php if (
                                        $page === $currentPage
                                    ): ?>

                                        <span class="w-9 h-9 rounded-xl bg-[#292322] text-white text-sm flex items-center justify-center font-medium">
                                            <?= $page ?>
                                        </span>

                                    <?php else: ?>

                                        <a
                                            href="<?= esc($pageUrl($page)) ?>"
                                            class="w-9 h-9 rounded-xl bg-white border border-black/10 text-[#5d5552] text-sm flex items-center justify-center hover:bg-[#f3eeeb] transition"
                                        >
                                            <?= $page ?>
                                        </a>

                                    <?php endif; ?>

                                <?php endfor; ?>


                                <?php if (
                                    $currentPage < $pageCount
                                ): ?>

                                    <a
                                        href="<?= esc($pageUrl($currentPage + 1)) ?>"
                                        class="px-3.5 py-2 rounded-xl border border-black/10 bg-white text-sm text-[#5d5552] hover:bg-[#f3eeeb] transition"
                                    >
                                        Next →
                                    </a>

                                <?php else: ?>

                                    <span class="px-3.5 py-2 rounded-xl border border-black/5 bg-[#f3eeeb] text-sm text-[#b4aca8]">
                                        Next →
                                    </span>

                                <?php endif; ?>

                            </div>

                        </div>

                    </div>

                <?php endif; ?>


            <?php endif; ?>

        </div>

    </div>

</div>


<!-- =========================================================
     EXPAND / COLLAPSE JAVASCRIPT
========================================================= -->

<script>

document.addEventListener('DOMContentLoaded', function () {


    /*
     * ========================================================
     * DESKTOP BOOKINGS
     * ========================================================
     */

    const desktopRows =
        document.querySelectorAll(
            '.booking-summary-row'
        );


    desktopRows.forEach(function (row) {

        row.addEventListener('click', function (event) {

            /*
             * Don't toggle when clicking an action link.
             */
            if (
                event.target.closest('a') ||
                event.target.closest('button')
            ) {
                return;
            }


            const detailId =
                row.dataset.detailId;

            const detail =
                document.getElementById(
                    detailId
                );


            if (!detail) {
                return;
            }


            const isHidden =
                detail.classList.contains('hidden');


            /*
             * Close all other desktop
             * booking details.
             *
             * This keeps the list clean.
             */
            document
                .querySelectorAll(
                    '.booking-details-row'
                )
                .forEach(function (item) {

                    if (item !== detail) {

                        item.classList.add(
                            'hidden'
                        );

                    }

                });


            /*
             * Reset all other chevrons.
             */
            document
                .querySelectorAll(
                    '.booking-summary-row'
                )
                .forEach(function (item) {

                    if (item !== row) {

                        const chevron =
                            item.querySelector(
                                '.booking-chevron'
                            );

                        if (chevron) {

                            chevron.style.transform =
                                'rotate(0deg)';

                        }

                    }

                });


            if (isHidden) {

                detail.classList.remove(
                    'hidden'
                );


                const chevron =
                    row.querySelector(
                        '.booking-chevron'
                    );

                if (chevron) {

                    chevron.style.transform =
                        'rotate(180deg)';

                }

            } else {

                detail.classList.add(
                    'hidden'
                );


                const chevron =
                    row.querySelector(
                        '.booking-chevron'
                    );

                if (chevron) {

                    chevron.style.transform =
                        'rotate(0deg)';

                }

            }

        });

    });


    /*
     * ========================================================
     * MOBILE BOOKINGS
     * ========================================================
     */

    const mobileCards =
        document.querySelectorAll(
            '.mobile-booking-card'
        );


    mobileCards.forEach(function (card) {

        card.addEventListener('click', function (event) {

            /*
             * Don't expand/collapse when
             * clicking Confirm / Cancel.
             */
            if (
                event.target.closest('a') ||
                event.target.closest('button')
            ) {
                return;
            }


            const detailId =
                card.dataset.mobileDetailId;

            const detail =
                document.getElementById(
                    detailId
                );


            if (!detail) {
                return;
            }


            const isHidden =
                detail.classList.contains(
                    'hidden'
                );


            /*
             * Close other mobile details.
             */
            document
                .querySelectorAll(
                    '.mobile-booking-details'
                )
                .forEach(function (item) {

                    if (item !== detail) {

                        item.classList.add(
                            'hidden'
                        );

                    }

                });


            /*
             * Reset other mobile chevrons.
             */
            document
                .querySelectorAll(
                    '.mobile-booking-card'
                )
                .forEach(function (item) {

                    if (item !== card) {

                        const chevron =
                            item.querySelector(
                                '.mobile-booking-chevron'
                            );

                        if (chevron) {

                            chevron.style.transform =
                                'rotate(0deg)';

                        }

                    }

                });


            if (isHidden) {

                detail.classList.remove(
                    'hidden'
                );


                const chevron =
                    card.querySelector(
                        '.mobile-booking-chevron'
                    );

                if (chevron) {

                    chevron.style.transform =
                        'rotate(180deg)';

                }

            } else {

                detail.classList.add(
                    'hidden'
                );


                const chevron =
                    card.querySelector(
                        '.mobile-booking-chevron'
                    );

                if (chevron) {

                    chevron.style.transform =
                        'rotate(0deg)';

                }

            }

        });

    });

});

</script>


<?= view('admin/layout/footer') ?>